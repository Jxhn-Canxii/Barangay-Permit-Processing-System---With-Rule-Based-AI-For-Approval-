<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class BarangayCensusController extends Controller
{
    // Display census data
    public function index()
    {
        return Inertia::render('Admin/BarangayCensus/Index', [
            'status' => session('status'),
        ]);
    }

    // List barangay census data with pagination
    public function listCensusData(Request $request)
    {
        $search = $request->input('search', '');
        $itemsPerPage = $request->input('itemsperpage', 10);
        $page = $request->input('page_num', 1);
        $offset = ($page - 1) * $itemsPerPage;

        // Query barangay census data
        $query = DB::table('barangay_census')
            ->where(function ($query) use ($search) {
                $query->where('year', 'LIKE', "%$search%") 
                      ->orWhere('population', 'LIKE', "%$search%")
                      ->orWhere('households', 'LIKE', "%$search%")
                      ->orWhere('male', 'LIKE', "%$search%")
                      ->orWhere('female', 'LIKE', "%$search%");
            });

        // Fetch paginated results
        $censusData = $query->orderBy('year', 'desc')
            ->offset($offset)
            ->limit($itemsPerPage)
            ->get();

        // Get total count
        $total = $query->count();

        return response()->json([
            'census' => $censusData,
            'total' => $total,
            'total_pages' => ceil($total / $itemsPerPage),
            'page_num' => $page,
            'itemsperpage' => $itemsPerPage,
            'search' => $search,
        ]);
    }

    // Store a new census record
    public function addCensus(Request $request)
    {
        $request->validate([
            'year' => 'required|integer|unique:barangay_census,year',
            'population' => 'required|integer|min:0',
            'households' => 'required|integer|min:0',
            'male' => 'required|integer|min:0',
            'female' => 'required|integer|min:0'
        ]);

        DB::table('barangay_census')->insert([
            'year' => $request->year,
            'population' => $request->population,
            'households' => $request->households,
            'male' => $request->male,
            'female' => $request->female,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json(['message' => 'Census record added successfully!'], 201);
    }


    // Update census record
    public function updateCensus(Request $request, $id)
    {
        $request->validate([
            'year' => 'required|integer|unique:barangay_census,year,' . $id,
            'population' => 'required|integer|min:0',
            'households' => 'required|integer|min:0',
            'male' => 'required|integer|min:0',
            'female' => 'required|integer|min:0'
        ]);

        $updated = DB::table('barangay_census')
            ->where('id', $id)
            ->update([
                'year' => $request->year,
                'population' => $request->population,
                'households' => $request->households,
                'male' => $request->male,
                'female' => $request->female,
                'updated_at' => now()
            ]);

        if ($updated) {
            return response()->json(['message' => 'Census record updated successfully!']);
        }

        return response()->json(['message' => 'Failed to update record.'], 500);
    }

    // Delete census record
    public function deleteCensus($id)
    {
        $deleted = DB::table('barangay_census')->where('id', $id)->delete();

        if ($deleted) {
            return response()->json(['message' => 'Census record deleted successfully!']);
        }

        return response()->json(['message' => 'Failed to delete record.'], 500);
    }

    // Fetch census data for Chart.js
    public function chartData()
    {
        $data = DB::table('barangay_census')->select('year', 'households', 'male', 'female')->orderBy('year', 'asc')->get();
        return response()->json($data);
    }
}
