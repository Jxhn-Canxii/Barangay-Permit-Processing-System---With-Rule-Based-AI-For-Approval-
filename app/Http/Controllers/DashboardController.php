<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Dashboard/Index', [
            'status' => session('status'),
        ]);
    }

    public function processingStats() {
        // Count the records grouped by status_id
        $statusCounts = DB::table('zoning_permits')
            ->select('status_id', DB::raw('count(*) as count'))
            ->whereIn('status_id', [1, 2, 3]) // Filter by status 1, 2, and 3
            ->groupBy('status_id')
            ->get();
    
        // Initialize an array to hold the counts
        $statusCountsArray = [
            'pending' => 0,
            'approved' => 0,
            'rejected' => 0,
        ];
    
        // Loop through the result and set the counts based on status_id
        foreach ($statusCounts as $statusCount) {
            if ($statusCount->status_id == 1) {
                $statusCountsArray['pending'] = $statusCount->count;
            } elseif ($statusCount->status_id == 2) {
                $statusCountsArray['approved'] = $statusCount->count;
            } elseif ($statusCount->status_id == 3) {
                $statusCountsArray['rejected'] = $statusCount->count;
            }
        }
    
        return response()->json($statusCountsArray);
    }
    
    
}
