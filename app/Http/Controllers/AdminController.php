<?php

namespace App\Http\Controllers;

use App\Models\Scan;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
                $brokenLinks = json_decode($scan->broken_links, true);
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
                'recentScans'
            ));
        }


    public function show($id){

        $scan = Scan::findOrFail($id);
        $brokenLinks = json_decode($scan->broken_links, true) ?? [];
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

    public function settings(){
        $totalScans = Scan::count();
        $totalIndexedLinks = Scan::sum('indexed');
        $totalBrokenLinks = Scan::sum('broken');
        $lastScan = Scan::latest()->first();

        return view('admin.settings', compact(
            'totalScans',
            'totalIndexedLinks',
            'totalBrokenLinks',
            'lastScan'
        ));
    }

    public function newScan()
    {
        return view('admin.new-scan');
    }
}

