<?php

namespace App\Http\Controllers;

use App\Models\Scan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
        public function index()
        {
            $sitesToday = Scan::whereDate('created_at', today())->count();

            $totalScans = Scan::count();

            $totalBrokenLinks = Scan::sum('broken');
            $totalIndexedLinks = Scan::sum('indexed');
            $totalSkipped = Scan::sum('skipped');
            $successRate = ($totalIndexedLinks + $totalBrokenLinks) > 0
                ? round(($totalIndexedLinks / ($totalIndexedLinks + $totalBrokenLinks)) * 100, 1)
                : 0;

            $totalLinks = $totalIndexedLinks + $totalBrokenLinks;
            $healthScore = $successRate;
            $totalSites = Scan::distinct('website')->count('website');

            $recentScans = Scan::latest()
                ->take(10)
                ->get();

            $websiteHistory = Scan::select(
                'website',
                DB::raw('COUNT(*) as total_scans'),
                DB::raw('MAX(id) as last_scan_id'),
                DB::raw('MAX(created_at) as last_scan')
            )
            ->groupBy('website')
            ->orderByDesc('last_scan')
            ->get();
            
            $lastScan = Scan::latest()->first();
            $scans = Scan::latest()->paginate(10);
            $topSites = Scan::orderByDesc('broken')
                ->take(5)
                ->get();           
            $scanChartData = [];

            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $scanChartData[] = Scan::whereDate(
                    'created_at',
                    $date->toDateString()
                )->count();
            }

            $scanChartData = Scan::selectRaw('DATE(created_at) as date, COUNT(*) as total')
                ->groupBy('date')
                ->orderBy('date')
                ->get();
            
            $httpErrors = [];
            $scansAll = Scan::all();
            foreach ($scansAll as $scan) {
                $brokenLinks = $scan->broken_links ?? [];
                if (is_string($brokenLinks)) {
                    $brokenLinks = json_decode($brokenLinks, true) ?? [];
                }
                if (!is_array($brokenLinks)) {
                    $brokenLinks = [];
                }
                if (!$brokenLinks) {
                    continue;
                }
                foreach ($brokenLinks as $link) {
                    if (isset($link['status'])) {
                        $status = $link['status'];
                        if (!isset($httpErrors[$status])) {
                            $httpErrors[$status] = 0;
                        }
                        $httpErrors[$status]++;
                    }
                }
            }

            return view('admin.dashboard', compact(
                'sitesToday',
                'totalScans',
                'totalBrokenLinks',
                'lastScan',
                'scans',
                'topSites',
                'scanChartData',
                'totalIndexedLinks',
                'httpErrors',
                'totalSkipped',
                'totalLinks',
                'successRate',
                'healthScore',
                'totalSites',
                'recentScans',
                'websiteHistory'
            ));
        }


        public function show($id)
        {
            $scan = Scan::findOrFail($id);

            $brokenLinks = $scan->broken_links ?? [];
            if (is_string($brokenLinks)) {
                $brokenLinks = json_decode($brokenLinks, true) ?? [];
            }

            if (!is_array($brokenLinks)) {
                $brokenLinks = [];
            }

            return view('admin.details', [
                'scan' => $scan,
                'brokenLinks' => $brokenLinks
            ]);
        }

        public function scans(){
            $scans = Scan::latest()->get();
            return view('admin.scans', compact('scans'));
        } 
   
        public function brokenLinks()
        {
            $scans = Scan::where('broken', '>', 0)
              ->latest()
               ->get();
            return view('admin.broken-links', compact('scans'));
        }

        public function reports()
        {
            $scanHistory = Scan::orderBy('broken', 'desc')
                ->get();

            return view('admin.reports', compact('scanHistory'));
        }

        public function settings()
        {
            $totalScans = Scan::count();
            $totalIndexedLinks = Scan::sum('indexed');
            $totalBrokenLinks = Scan::sum('broken');
            $lastScan = Scan::latest()->first();
            $settings = Setting::first();

            if (!$settings) {
                $settings = Setting::create([
                    'admin_name' => '',
                    'admin_email' => '',
                    'generate_reports' => true,
                ]);
            }

            return view('admin.settings', compact(
                'totalScans',
                'totalIndexedLinks',
                'totalBrokenLinks',
                'lastScan',
                'settings'
            ));
        }


        public function updateSettings(Request $request)
        {
            $request->validate([
                'admin_name' => 'required|string|max:255',
                'admin_email' => 'required|email',
            ]);

            $settings = Setting::first();

            $settings->update([
                'admin_name' => $request->admin_name,
                'admin_email' => $request->admin_email,
                'generate_reports' => $request->has('generate_reports'),
            ]);

            return back()->with('success', 'Settings saved successfully.');
        }


        public function newScan()
        {
            return view('admin.new-scan');
        }

    public function startScan(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
        ]);

        $url = trim($request->url);

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

        $existingScan = Scan::where('finished', true)
            ->where('created_at', '>=', now()->subHours(24))
            ->where(function ($query) use ($cleanHost) {
                $query->whereRaw(
                    "REPLACE(LOWER(host), 'www.', '') = ?",
                    [$cleanHost]
                );
            })
            ->latest('created_at')
            ->first();

        if ($existingScan) {

            session([
                'admin_scan_id' => $existingScan->id
            ]);     

            return response()->json([
                'success' => true,
                'existing' => true,
                'scan_id' => $existingScan->id,
                'indexed' => $existingScan->indexed,
                'broken' => $existingScan->broken,
                'skipped' => $existingScan->skipped,

                'message' => 'Un résultat récent existe déjà.'
            ]);
        }

        try {

            $response = \Illuminate\Support\Facades\Http::timeout(20)
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
                    'message' => 'Impossible d accéder au site.'
                ], 400);
            }

            $dom = new \DOMDocument();

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

                $newHost = parse_url($href, PHP_URL_HOST);

                $cleanNewHost = str_replace(
                    'www.',
                    '',
                    strtolower($newHost)
                );

                if ($cleanNewHost !== $cleanHost) {
                    continue;
                }

                $links[] = $href;
            }

            $links = array_values(array_unique($links));
            $scan = Scan::create([
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

            session([
                'admin_scan_id' => $scan->id
            ]);

            return response()->json([
                'success' => true,
                'scan_id' => $scan->id
            ]);

        } catch (\Exception $e) {

            \Log::error('ADMIN SCAN ERROR: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function scanStep(Request $request)      
    {
        $scanId = session('admin_scan_id');

        if (!$scanId) {
            return response()->json([
                'error' => 'Scan administrateur introuvable.'
            ], 404);
        }

        $scan = Scan::find($scanId);

        if (!$scan) {
            return response()->json([
                'error' => 'Scan introuvable dans la base de données.'
            ], 404);
        }

        $toVisit = $scan->to_visit ?? [];
        $visited = $scan->visited ?? [];
        $brokenLinks = $scan->broken_links ?? [];

        $indexed = $scan->indexed ?? 0;
        $broken = $scan->broken ?? 0;
        $skipped = $scan->skipped ?? 0;

        $baseUrl = $scan->base_url;
        $host = $scan->host;

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


        $currentLink = array_shift($toVisit);

        \Log::info('ADMIN SCAN URL : ' . $currentLink);

        if (in_array($currentLink, $visited)) {
            $skipped++;
        } else {

            $visited[] = $currentLink;

            try {

                $response = \Illuminate\Support\Facades\Http::timeout(30)
                    ->connectTimeout(10)
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
                    ->get($currentLink);

                $status = $response->status();

            } catch (\Exception $e) {
                \Log::error(
                    'ADMIN SCAN ERROR [' .
                    $currentLink .
                    '] : ' .
                    $e->getMessage()
                );

                $status = 0;
                $response = null;
            }


            if ($status >= 200 && $status < 400) {
                $indexed++;

                if ($response && !empty($response->body())) {
                    $dom = new \DOMDocument();

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
                                $href =
                                    rtrim($baseUrl, '/') .
                                    '/' .
                                    ltrim($href, '/');
                            }
                        }

                        $href = strtok($href, '#');
                        $href = rtrim($href, '/');

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

                        if (str_starts_with($href, 'http')) {

                            $newHost = parse_url(
                                $href,
                                PHP_URL_HOST
                            );

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
                                $cleanNewHost === $cleanHost &&
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


    public function result(Request $request)          
    {
        $scanId = $request->scan_id ?? session('admin_scan_id');

        if (!$scanId) {
            return redirect()
                ->route('admin.new-scan')
                ->with('error', 'Aucun scan trouvé.');
        }

        $scan = Scan::find($scanId);

        if (!$scan) {
            return redirect()
                ->route('admin.new-scan')
                ->with('error', 'Scan introuvable.');
        }

        session([
            'admin_scan_id' => $scan->id
        ]);

        return view('admin.details', [
            'scan' => $scan,
            'brokenLinks' => $scan->broken_links ?? [],
        ]);
    }


    public function exportCsv()       //export csv    
    {
        $settings = Setting::first();
        $scans = Scan::latest()->get();

        $fileName = 'all_scans_report.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        return response()->stream(function () use ($scans, $settings) {

            $handle = fopen('php://output', 'w');

            // Titre du rapport
            fputcsv($handle, ['BROKEN LINK CHECKER REPORT']);
            fputcsv($handle, []);

            // Informations administrateur
            if ($settings && $settings->generate_reports) {
                fputcsv($handle, ['Generated by', $settings->admin_name]);
                fputcsv($handle, ['Administrator Email', $settings->admin_email]);
                fputcsv($handle, ['Generated on', now()->format('d/m/Y H:i')]);
                fputcsv($handle, []);
            }

            // En-têtes des colonnes
            fputcsv($handle, [
                'Website',
                'Indexed Links',
                'Broken Links',
                'Skipped Links',
                'Scan Date'
            ]);

            // Données
            foreach ($scans as $scan) {
                fputcsv($handle, [
                    $scan->website,
                    $scan->indexed,
                    $scan->broken,
                    $scan->skipped,
                    $scan->created_at->format('d/m/Y H:i'),
                ]);
            }
            fclose($handle);

        }, 200, $headers);
    }


    public function exportPdf()             //export pdf
    {
        $settings = Setting::first();
        $scans = Scan::latest()->get();

        $stats = [
            'totalScans' => Scan::count(),
            'indexed' => Scan::sum('indexed'),
            'broken' => Scan::sum('broken'),
            'skipped' => Scan::sum('skipped'),
        ];

        $pdf = Pdf::loadView('admin.pdf.report', [
            'settings' => $settings,
            'scans' => $scans,
            'stats' => $stats,
        ]);

        return $pdf->download('all_scans_report.pdf');
    }


    public function websiteHistory($id)   //Historiques scans user
    {
        $scan = Scan::findOrFail($id);

        $history = Scan::where('website', $scan->website)
            ->orderBy('created_at')
            ->get();

        $chartData = $history
            ->groupBy(function ($scan) {
                return $scan->created_at->format('d/m');
            })
            ->map(function ($day) {
                return [
                    'date' => $day->first()->created_at->format('d/m'),
                    'broken' => $day->sum('broken'),
                    'indexed' => $day->sum('indexed'),
                    'scans' => $day->count(),
                ];
            })
            ->values();

        return view('admin.website-history', [
            'website' => $scan->website,
            'history' => $history,
            'chartData' => $chartData,
        ]);
    }
}


