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
    
    public function educationalAttainmentStats() {
        // Fetch the count of residents grouped by educational attainment
        $educationalAttainmentCounts = DB::table('residents')
            ->select('educationalattainment', DB::raw('count(*) as count'))
            ->groupBy('educationalattainment')
            ->get();
        
        // Prepare the data to be returned
        $educationalAttainmentData = [];
    
        foreach ($educationalAttainmentCounts as $attainment) {
            $educationalAttainmentData[] = [
                'category' => $attainment->educationalattainment,
                'count' => $attainment->count,
            ];
        }
    
        // Return the data as JSON for use in the frontend
        return response()->json($educationalAttainmentData);
    }

    public function ageDistributionStats() {
        // Fetch the count of residents grouped by age range (e.g., 0-18, 19-30, etc.)
        $ageDistribution = DB::table('residents')
            ->select(DB::raw('
                CASE
                    WHEN age BETWEEN 0 AND 18 THEN "0-18"
                    WHEN age BETWEEN 19 AND 30 THEN "19-30"
                    WHEN age BETWEEN 31 AND 40 THEN "31-40"
                    WHEN age BETWEEN 41 AND 50 THEN "41-50"
                    WHEN age BETWEEN 51 AND 60 THEN "51-60"
                    WHEN age > 60 THEN "60+"
                    ELSE "Unknown"
                END as age_range, 
                COUNT(*) as count
            '))
            ->groupBy('age_range')
            ->get();
        
        return response()->json($ageDistribution);
    }
    
    public function genderDistributionStats() {
        // Fetch the count of residents grouped by gender
        $genderCounts = DB::table('residents')
            ->select('gender', DB::raw('count(*) as count'))
            ->groupBy('gender')
            ->get();
        
        return response()->json($genderCounts);
    }
    
    public function vaccinationStatusStats() {
        // Fetch the count of residents grouped by fully immunized status
        $vaccinationStats = DB::table('residents')
            ->select('fullyimmunized', DB::raw('count(*) as count'))
            ->groupBy('fullyimmunized')
            ->get();
        
        return response()->json($vaccinationStats);
    }
    
    public function housingTypeStats() {
        // Fetch the count of residents grouped by housing type
        $housingTypeCounts = DB::table('residents')
            ->select('housetype', DB::raw('count(*) as count'))
            ->groupBy('housetype')
            ->get();
        
        return response()->json($housingTypeCounts);
    }

    public function disabilityStatusStats() {
        // Fetch the count of residents grouped by disability status
        $disabilityStatusCounts = DB::table('residents')
            ->select('disabilitystatus', DB::raw('count(*) as count'))
            ->groupBy('disabilitystatus')
            ->get();
        
        return response()->json($disabilityStatusCounts);
    }

    public function householdSizeStats() {
        // Fetch the average number of household members
        $averageHouseholdSize = DB::table('residents')
            ->select(DB::raw('AVG(numberofhousemembers) as average_household_size'))
            ->first();
        
        return response()->json($averageHouseholdSize);
    }
    
    
}
