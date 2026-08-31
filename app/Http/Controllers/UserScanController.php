<?php

namespace App\Http\Controllers;

use App\Models\Scan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use DOMDocument;     //analyse le code html
use App\Mail\ScanReportMail;
use Illuminate\Support\Facades\Mail;
use App\Models\UserScan;




class UserScanController extends Controller
{
    private $baseUrl;
    private $host;

    public function index(){
        return view('welcome');
    }
      
    
    public function startScan(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
        ]);

        $url = trim($request->url);

        // NORMALISATION DE L'URL
        $scheme = parse_url($url, PHP_URL_SCHEME);
        $host = parse_url($url, PHP_URL_HOST);

        if (!$scheme || !$host) {
            return response()->json([
                'success' => false,
                'message' => 'URL invalide.'
            ], 400);
        }

        $cleanHost = str_replace(
            'www.',
            '',
            strtolower($host)
        );

        $baseUrl = $scheme . '://' . $host;

        //recherche un scan existant 
        $existingScan = UserScan::where('finished', true)
        ->where('updated_at', '>=', now()->subHours(24))
        ->where(function ($query) use ($cleanHost) {

            $query->whereRaw(
                "REPLACE(LOWER(host), 'www.', '') = ?",
                [$cleanHost]
            );
        })
        ->latest('updated_at')
        ->first();

            //si scan existant utililser le resultat
            if ($existingScan) {
            $scan = UserScan::create([
                'user_id' => auth()->id(),
                'website' => $url,
                'base_url' => $existingScan->base_url,
                'host' => $existingScan->host,

                // Aucun nouveau scan nécessaire
                'to_visit' => [],

                //les résultats du existants
                'visited' => $existingScan->visited ?? [],
                'broken_links' => $existingScan->broken_links ?? [],
                'indexed' => $existingScan->indexed ?? 0,
                'broken' => $existingScan->broken ?? 0,
                'skipped' => $existingScan->skipped ?? 0,

                // Le scan est déjà terminé
                'finished' => true,
                'created_at' => $existingScan->created_at,
                'updated_at' => $existingScan->updated_at,
            ]);

            // Sauvegarder le nouveau scan dans la session
            session([
                'user_scan_id' => $scan->id
            ]);

            return response()->json([
                'success' => true,
                'existing' => true,
                'scan_id' => $scan->id,
                'indexed' => $scan->indexed,
                'broken' => $scan->broken,
                'skipped' => $scan->skipped,
                'message' => 'Résultat existant récupéré depuis la base de données.'
            ]);
        }

            //si aucun scan existant lancer un nouveau scan
        try {
            $response = Http::timeout(20)
                ->withoutVerifying()
                ->withOptions([
                    'allow_redirects' => true,
                ])
                ->withHeaders([
                    'User-Agent' =>
                        'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/138.0.0.0 Safari/537.36',

                    'Accept' =>
                        'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',

                    'Accept-Language' =>
                        'en-US,en;q=0.9',
                ])
                ->get($url);

            if (!$response->successful()) {
                return response()->json([
                    'success' => false,
                    'status' => $response->status(),
                    'body' => substr($response->body(), 0, 300)
                ], 400);
            }

            // ANALYSE DE LA PAGE
            $dom = new DOMDocument();

            libxml_use_internal_errors(true);

            $dom->loadHTML($response->body());

            libxml_clear_errors();

            $links = [];

            foreach ($dom->getElementsByTagName('a') as $link) {

                $href = trim($link->getAttribute('href'));
                $href = strtok($href, '#');

                if (
                    empty($href) ||
                    str_starts_with($href, 'mailto:') ||
                    str_starts_with($href, 'tel:') ||
                    str_starts_with($href, 'sms:') ||
                    str_starts_with($href, 'javascript:') ||
                    str_starts_with($href, 'data:')
                ) {
                    continue;
                }

                // CONVERSION DES URL RELATIVES
                if (!str_starts_with($href, 'http')) {
                    if (str_starts_with($href, '/')) {
                        $href = rtrim($baseUrl, '/') . $href;

                    } else {
                        $href =
                            rtrim($baseUrl, '/') .
                            '/' .
                            ltrim($href, '/');
                    }
                }

                $href = strtok($href, '#');
                $href = rtrim($href, '/');

                // EXTENSIONS IGNORÉES
                $extension = strtolower(
                    pathinfo(
                        parse_url($href, PHP_URL_PATH),
                        PATHINFO_EXTENSION
                    )
                );

                $ignoredExtensions = [
                    'jpg',
                    'jpeg',
                    'png',
                    'gif',
                    'svg',
                    'webp',
                    'css',
                    'js',
                    'ico',
                    'pdf',
                    'zip',
                    'mp4'
                ];

                if (in_array($extension, $ignoredExtensions)) {
                    continue;
                }

                // GARDER UNIQUEMENT LE MÊME DOMAINE
                $newHost = parse_url($href, PHP_URL_HOST);

                $cleanNewHost = str_replace(
                    'www.',
                    '',
                    strtolower($newHost)
                );

                if ($cleanNewHost != $cleanHost) {
                    continue;
                }
                $links[] = $href;
            }

            $links = array_values(
                array_unique($links)
            );

            // CRÉATION DU SCAN EN BDD
            $scan = UserScan::create([
                'user_id' => auth()->check() ? auth()->id() : null,
                'website' => $url,
                'base_url' => $baseUrl,
                'host' => $host,
                'to_visit' => $links,
                'visited' => [],
                'broken_links' => [],
                'indexed' => 0,
                'broken' => 0,
                'skipped' => 0,
                'finished' => false,
            ]);

            // STOCKER L'ID DU SCAN DANS LA SESSION
            session([
                'user_scan_id' => $scan->id
            ]);

            return response()->json([
                'success' => true,
                'existing' => false,
                'scan_id' => $scan->id
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function scanStep(Request $request)
    {
        // Récupérer l'ID du scan depuis la session
        $scanId = session('user_scan_id');

        if (!$scanId) {
            return response()->json([
                'error' => 'Scan utilisateur introuvable.'
            ], 404);
        }

        // Récupérer le scan depuis la table user_scans
        $scan = UserScan::find($scanId);

        if (!$scan) {
            return response()->json([
                'error' => 'Scan introuvable dans la base de données.'
            ], 404);
        }

        // Vérifier que le scan appartient bien à l'utilisateur connecté
        if ($scan->user_id !== auth()->id()) {
            return response()->json([
                'error' => 'Accès non autorisé.'
            ], 403);
        }

        // Récupérer les données du scan
        $toVisit = $scan->to_visit ?? [];
        $visited = $scan->visited ?? [];
        $brokenLinks = $scan->broken_links ?? [];

        $indexed = $scan->indexed ?? 0;
        $broken = $scan->broken ?? 0;
        $skipped = $scan->skipped ?? 0;

        $baseUrl = $scan->base_url;
        $host = $scan->host;

        // FIN DU SCAN
        if (empty($toVisit)) {

            $scan->update([
                'broken_links' => $brokenLinks,
                'indexed' => $indexed,
                'broken' => $broken,
                'skipped' => $skipped,
                'finished' => true,
                'to_visit' => $toVisit,
                'visited' => $visited,
            ]);

            return response()->json([
                'finished' => true,
                'progress' => 100,
                'indexed' => $indexed,
                'broken' => $broken,
                'skipped' => $skipped
            ]);
        }

        // PRENDRE LE PROCHAIN LIEN
        $currentLink = array_shift($toVisit);

        \Log::info('SCAN URL : ' . $currentLink);

        if (in_array($currentLink, $visited)) {

            $skipped++;
        } else {
            $visited[] = $currentLink;
            try {

                $response = Http::timeout(30)
                    ->connectTimeout(10)
                    ->withoutVerifying()
                    ->withOptions([
                        'allow_redirects' => true,
                    ])
                    ->withHeaders([
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36',
                        'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                        'Accept-Language' => 'en-US,en;q=0.9',
                    ])
                    ->get($currentLink);
                $status = $response->status();
            } catch (\Exception $e) {
                \Log::error(
                    'SCAN ERROR [' . $currentLink . '] : ' . $e->getMessage()
                );

                $status = 0;
                $response = null;
            }

            // LIEN VALIDE
            if ($status >= 200 && $status < 400) {

                $indexed++;

                if ($response && !empty($response->body())) {

                    $dom = new DOMDocument();

                    libxml_use_internal_errors(true);
                    $dom->loadHTML($response->body());
                    libxml_clear_errors();

                    foreach ($dom->getElementsByTagName('a') as $link) {
                        $href = trim($link->getAttribute('href'));
                        $href = strtok($href, '#');
                        $href = rtrim($href, '/');

                        if (
                            empty($href) ||
                            str_starts_with($href, 'mailto:') ||
                            str_starts_with($href, 'tel:') ||
                            str_starts_with($href, 'sms:') ||
                            str_starts_with($href, 'javascript:') ||
                            str_starts_with($href, 'data:')
                        ) {
                            continue;
                        }


                        if (!str_starts_with($href, 'http')) {
                            if (str_starts_with($href, '/')) {
                                $href = rtrim($baseUrl, '/') . $href;
                            } else {
                                $href = rtrim($baseUrl, '/') . '/' . ltrim($href, '/');
                            }
                        }

                        if (str_starts_with($href, 'http')) {
                            $newHost = parse_url($href, PHP_URL_HOST);
                            $cleanHost = str_replace(
                                'www.',
                                '',
                                strtolower($host)
                            );

                            $cleanNewHost = str_replace(
                                'www.',
                                '',
                                strtolower($newHost)
                            );

                            if (
                                $cleanNewHost == $cleanHost &&
                                !in_array($href, $visited) &&
                                !in_array($href, $toVisit)
                            ) {
                                $toVisit[] = $href;
                            }
                        }
                    }
                }
            } else {
                // LIEN CASSÉ
                if ($status >= 400 || $status == 0) {

                    if (
                        !in_array(
                            $currentLink,
                            array_column($brokenLinks, 'url')
                        )
                    ) {
                        $broken++;

                        $brokenLinks[] = [
                            'url' => $currentLink,
                            'status' => $status
                        ];
                    }
                }
            }
        }
        // CALCUL PROGRESSION

        $totalProcessed = count($visited);
        $totalRemaining = count($toVisit);

        if (($totalProcessed + $totalRemaining) > 0) {
            $progress = intval(
                ($totalProcessed /
                ($totalProcessed + $totalRemaining)) * 100
            );
        } else {
            $progress = 100;
        }

        // SAUVEGARDER DANS user_scans
        $scan->update([
            'to_visit' => $toVisit,
            'visited' => $visited,
            'broken_links' => $brokenLinks,
            'indexed' => $indexed,
            'broken' => $broken,
            'skipped' => $skipped,
            'finished' => false,
        ]);

        return response()->json([
            'finished' => false,
            'progress' => $progress,
            'indexed' => $indexed,
            'broken' => $broken,
            'skipped' => $skipped
        ]);
    }
   

   public function checkUrl(Request $request)
    {
        $url = $request->url;

        $baseUrl = parse_url($url, PHP_URL_SCHEME) . '://' .
                parse_url($url, PHP_URL_HOST);

        $indexed = 0;
        $broken = 0;
        $skipped = 0;           
        try {

            $response = Http::timeout(20)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36',
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                    'Accept-Language' => 'en-US,en;q=0.9',
                ])
                ->get($url);

            if (!$response->successful()) {
            return response()->json([
                    'success' => false
                ]);
            }

            $dom = new DOMDocument();

            libxml_use_internal_errors(true);
            $dom->loadHTML($response->body());
            libxml_clear_errors();

            foreach ($dom->getElementsByTagName('a') as $link) {

                $href = trim($link->getAttribute('href'));

                if (empty($href)) {
                    continue;
                }

                if (
                    str_starts_with($href, '#') ||
                    str_starts_with($href, 'mailto:') ||
                    str_starts_with($href, 'javascript:')
                ) {
                    $skipped++;
                    continue;
                }

                if (!str_starts_with($href, 'http')) {
                    $href = rtrim($baseUrl, '/') . '/' . ltrim($href, '/');
                }

                try {

                    $linkResponse = Http::timeout(10)
                        ->withoutVerifying()
                        ->withOptions([
                            'allow_redirects' => true,
                        ])
                        ->withHeaders([
                            'User-Agent' => 'Mozilla/5.0'
                        ])
                        ->head($href);

                    // Si HEAD n'est pas autorisé, on utilise GET
                    if ($linkResponse->status() == 405) {

                    $linkResponse = Http::timeout(10)
                            ->withoutVerifying()
                            ->withOptions([
                                'allow_redirects' => true,
                            ])
                            ->withHeaders([
                                'User-Agent' => 'Mozilla/5.0'
                            ])
                            ->get($href);
                    }

                    $status = $linkResponse->status();

                    $indexed++;

                    if ($status >= 400) {
                        $broken++;
                    }

                } catch (\Exception $e) {

                    $indexed++;
                    $broken++;
                }
            }
            return response()->json([
                'success' => true,
                'indexed' => $indexed,
                'broken' => $broken,
                'skipped' => $skipped
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }

    }
    
    
    public function result(Request $request)
    {
        $scanId = session('user_scan_id');

        if (!$scanId) {
            return redirect('/')->with('error', 'Aucun scan trouvé.');
        }

        $scan = UserScan::find($scanId);

        if (!$scan) {
            return redirect('/')->with('error', 'Scan introuvable.');
        }

        if ($scan->user_id === null && auth()->check()) {
            $scan->user_id = auth()->id();
            $scan->save();
        }

        // Vérifier que le scan appartient bien à l'utilisateur connecté
        if ($scan->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé.');
        }

        return view('result', [
            'scan' => $scan,
            'website' => $scan->website,
            'indexed' => $scan->indexed,
            'skipped' => $scan->skipped,
            'brokenLinks' => $scan->broken_links ?? [],
            'updated' => $scan->updated_at,
        ]);
    }
    


    public function exportCsv()
    {
        $scanId = session('user_scan_id');

        if (!$scanId) {
            abort(404, 'Aucun scan trouvé.');
        }

        $scan = UserScan::find($scanId);

        if (!$scan) {
            abort(404, 'Scan introuvable.');
        }

        // Vérifier que le scan appartient à l'utilisateur connecté
        if ($scan->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé.');
        }

        $brokenLinks = $scan->broken_links ?? [];

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="broken-links.csv"',
        ];

        $callback = function () use ($brokenLinks) {

            $file = fopen('php://output', 'w');

            fputcsv($file, ['URL', 'Status']);

            foreach ($brokenLinks as $link) {

                fputcsv($file, [
                    $link['url'],
                    $link['status']
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    
    public function sendReport(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
        ]);

        try {
            $scan = (object) session('scan');

            if (!$scan) {
                return back()->with('error', 'Aucun scan trouvé.');
            }
 
            Mail::to($request->email)
              ->send(new ScanReportMail($scan, $request->name));

            return back()->with(
                'success',
                'Report sent successfully to ' . $request->email
            );

        } catch (\Exception $e) {
            return back()->with(
                'error',
                $e->getMessage()
            );
        }
    }
     
    
    public function history()
    {
        $scans = UserScan::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.history', compact('scans'));
    }    


    public function historyShow($id)
    {
        $scan = UserScan::find($id);

        if (!$scan) {
            abort(404, 'Scan introuvable.');
        }

        // Sécurité : vérifier que le scan appartient à l'utilisateur connecté
        if ($scan->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé.');
        }

        return view('user.history-show', [
            'scan' => $scan,
            'website' => $scan->website,
            'indexed' => $scan->indexed,
            'brokenLinks' => $scan->broken_links ?? [],
            'skipped' => $scan->skipped,
            'updated' => $scan->updated_at,
        ]);
    }

}

