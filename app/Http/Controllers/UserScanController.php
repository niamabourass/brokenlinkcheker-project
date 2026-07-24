<?php

namespace App\Http\Controllers;

use App\Models\Scan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use DOMDocument;     //analyse le code html
use App\Mail\ScanReportMail;
use Illuminate\Support\Facades\Mail;



class UserScanController extends Controller
{
    private $baseUrl;
    private $host;

    public function index(){
        return view('welcome');
    }
      
    public function startScan(Request $request)
{
    $url = $request->url;

    $scheme = parse_url($url, PHP_URL_SCHEME);
    $host = parse_url($url, PHP_URL_HOST);

    $baseUrl = $scheme . "://" . $host;

    try {

        $response = Http::timeout(20)
            ->withoutVerifying()
            ->withOptions([
                'allow_redirects' => true,
            ])
            ->withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                'Accept-Language' => 'en-US,en;q=0.9',
            ])
            ->get($url);

        if (!$response->successful()) {

            return response()->json([
                'success' => false,
                'status' => $response->status(),
                'body' => substr($response->body(), 0, 300)
            ], 400);
        }

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

            if (!str_starts_with($href, 'http')) {

                if (str_starts_with($href, '/')) {
                    $href = rtrim($baseUrl, '/') . $href;
                } else {
                    $href = rtrim($baseUrl, '/') . '/' . ltrim($href, '/');
                }
            }

            $href = strtok($href, '#');
            $href = rtrim($href, '/');

            $extension = strtolower(
                pathinfo(parse_url($href, PHP_URL_PATH), PATHINFO_EXTENSION)
            );

            $ignoredExtensions = [
                'jpg','jpeg','png','gif',
                'svg','webp','css',
                'js','ico','pdf','zip','mp4'
            ];

            if (in_array($extension, $ignoredExtensions)) {
                continue;
            }

            $newHost = parse_url($href, PHP_URL_HOST);

            if (
                str_replace('www.', '', strtolower($newHost))
                !=
                str_replace('www.', '', strtolower($host))
            ) {
                continue;
            }

            $links[] = $href;
        }

        $links = array_values(array_unique($links));

        // ==========================
        // Stockage en SESSION
        // ==========================

        session([
            'scan' => [
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
            ]
        ]);

        return response()->json([
            'success' => true,
            'scan_id' => 1
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 400);

    }
}

    public function scanStep(Request $request){       //verifie statut et incremente comp et sauv 
       
         $scan = session('scan');

        if (!$scan) {
            return response()->json([
                'error' => 'Session de scan introuvable.'
            ], 404);
        }

        $toVisit = $scan['to_visit'];
        $visited = $scan['visited'];
        $brokenLinks = $scan['broken_links'];

        $indexed = $scan['indexed'];
        $broken = $scan['broken'];
        $skipped = $scan['skipped'];

        $baseUrl = $scan['base_url'];
        $host = $scan['host'];

        if (empty($toVisit)) {

            $scan['broken_links'] = $brokenLinks;
            $scan['indexed'] = $indexed;
            $scan['broken'] = $broken;
            $scan['skipped'] = $skipped;
            $scan['finished'] = true;

            session(['scan' => $scan]);

            return response()->json([
               'finished' => true,
               'progress' => 100,
               'indexed' => $indexed,
               'broken' => $broken,
               'skipped' => $skipped
            ]);
        }

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

           \Log::error('SCAN ERROR [' . $currentLink . '] : ' . $e->getMessage());

            $status = 0;
            $response = null;
        }

        if ($status >= 200 && $status < 400) {
            $indexed++;
            if (!empty($response->body())) {

                $dom = new DOMDocument();

                libxml_use_internal_errors(true);
                $dom->loadHTML($response->body());
                libxml_clear_errors();

                foreach ($dom->getElementsByTagName('a') as $link) {

                    $href = trim($link->getAttribute('href'));

                    $href = strtok($href, '#');
                    $href = rtrim($href,'/');

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

                        $cleanHost = str_replace('www.', '', strtolower($host));
                        $cleanNewHost = str_replace('www.', '', strtolower($newHost));

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

            if ($status >= 400 || $status == 0) {
                if(!in_array($currentLink, array_column($brokenLinks,'url'))){
                    $broken++;
                    $brokenLinks[] = [
                        'url'=>$currentLink,
                        'status'=>$status
                    ];
                }
            }
        }
    }

           $totalProcessed = count($visited);
            $totalRemaining = count($toVisit);

            if (($totalProcessed + $totalRemaining) > 0) {
                $progress = intval(
                    ($totalProcessed / ($totalProcessed + $totalRemaining)) * 100
                );
            } else {
                $progress = 100;
            }

        $scan['to_visit'] = $toVisit;
        $scan['visited'] = $visited;
        $scan['broken_links'] = $brokenLinks;
        $scan['indexed'] = $indexed;
        $scan['broken'] = $broken;
        $scan['skipped'] = $skipped;

        session(['scan' => $scan]);

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
        $scan = session('scan');

        if (!$scan) {
            return redirect('/')->with('error', 'Aucun scan trouvé.');
        }

        return view('result', [
            'scan' => (object) $scan,
            'website' => $scan['website'],
            'indexed' => $scan['indexed'],
            'skipped' => $scan['skipped'],
            'brokenLinks' => $scan['broken_links'],
            'updated' => now(),
        ]);
    }
    


    public function exportCsv()
    {
        $scan = session('scan');

        if (!$scan) {
            abort(404, 'Aucun scan trouvé.');
        }

        $brokenLinks = $scan['broken_links'];

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
        

}

