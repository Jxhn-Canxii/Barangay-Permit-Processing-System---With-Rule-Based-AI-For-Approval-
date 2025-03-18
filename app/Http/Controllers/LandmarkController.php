<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class LandmarkController extends Controller
{
    // Get all landmarks
    public function index()
    {
        return Inertia::render('Admin/Landmarks/Index', [
            'status' => session('status'),
        ]);
    }

    public function listLandmarks(Request $request)
    {
        $search = $request->input('search', '');
        $itemsPerPage = $request->input('itemsperpage', 10);
        $page = $request->input('page_num', 1);
        $offset = ($page - 1) * $itemsPerPage;

        // Query barangay census data
        $query = DB::table('landmarks')
            ->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', "%$search%") 
                      ->orWhere('description', 'LIKE', "%$search%")
                      ->orWhere('building_type', 'LIKE', "%$search%")
                      ->orWhere('latitude', 'LIKE', "%$search%")
                      ->orWhere('longitude', 'LIKE', "%$search%");
            });

        // Fetch paginated results
        $censusData = $query->orderBy('id', 'desc')
            ->offset($offset)
            ->limit($itemsPerPage)
            ->get();

        // Get total count
        $total = $query->count();

        return response()->json([
            'landmarks' => $censusData,
            'total' => $total,
            'total_pages' => ceil($total / $itemsPerPage),
            'page_num' => $page,
            'itemsperpage' => $itemsPerPage,
            'search' => $search,
        ]);
    }

    // Store a new landmark
    public function add(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'building_type' => 'nullable|string',
            'latitude' => 'required|numeric|regex:/^-?\d{1,2}\.\d{6,}$/',
            'longitude' => 'required|numeric|regex:/^-?\d{1,3}\.\d{6,}$/',
        ]);
        

        $id = DB::table('landmarks')->insertGetId($validatedData);

        $landmark = DB::table('landmarks')->where('id', $id)->first();

        return response()->json([
            'message' => 'Landmark created successfully',
            'data' => $landmark
        ], 201);
    }

    // Show a single landmark
    public function show($id)
    {
        $landmark = DB::table('landmarks')->where('id', $id)->first();

        if (!$landmark) {
            return response()->json(['message' => 'Landmark not found'], 404);
        }

        return response()->json($landmark, 200);
    }

    // Update a landmark
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'building_type' => 'nullable|string',
            'latitude' => 'required|numeric|regex:/^-?\d{1,2}\.\d{6,}$/',
            'longitude' => 'required|numeric|regex:/^-?\d{1,3}\.\d{6,}$/',
        ]);
        

        $affected = DB::table('landmarks')->where('id', $id)->update($validatedData);

        if ($affected === 0) {
            return response()->json(['message' => 'No changes made or landmark not found'], 404);
        }

        $landmark = DB::table('landmarks')->where('id', $id)->first();

        return response()->json([
            'message' => 'Landmark updated successfully',
            'data' => $landmark
        ], 200);
    }

    // Delete a landmark
    public function deleteLandmarks($id)
    {
        $deleted = DB::table('landmarks')->where('id', $id)->delete();

        if ($deleted) {
            return response()->json(['message' => 'Landmark deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Landmark not found'], 404);
        }
    }
}
