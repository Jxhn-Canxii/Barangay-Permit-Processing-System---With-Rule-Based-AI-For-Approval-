<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class RuleController extends Controller
{
    // Display all rules
    public function index()
    {
        return Inertia::render('Admin/Rules/Index', [
            'status' => session('status'),
        ]);
    }

    // Display a single rule
    // Fetch user list separately (API response)
    public function list(Request $request)
    {
        $search = $request->input('search', '');
        $itemsPerPage = $request->input('itemsperpage', 10);
        $page = $request->input('page_num', 1);
        $offset = ($page - 1) * $itemsPerPage;
    
        // Get authenticated user
        $user = auth()->user();
    
        // Query logs with user name from users table
        $query = DB::table('rules')
            ->where('name', 'LIKE', "%$search%");
    
    
        // Fetch paginated results
        $rules = $query->orderBy('id', 'desc')
            ->offset($offset)
            ->limit($itemsPerPage)
            ->get();
    
        // Get total count
        $total = $query->count();
    
        return response()->json([
            'rules' => $rules,
            'total' => $total,
            'total_pages' => ceil($total / $itemsPerPage),
            'page_num' => $page,
            'itemsperpage' => $itemsPerPage,
            'search' => $search,
        ]);
    }

    // Create a new rule
    public function add(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'zoning_district' => 'required|integer|min:1',
            'required_area' => 'required|integer',
            'minimum_lot_area' => 'required|integer',
            'acceptable_land_rights' => 'required|array',
            'setback_compliance_required' => 'required|boolean',
        ]);

        // Insert data into 'rules' table using DB facade
        $inserted = DB::table('rules')->insert([
            'name' => $validated['name'],
            'zoning_district' => $validated['zoning_district'],
            'required_area' => $validated['required_area'],
            'minimum_lot_area' => $validated['minimum_lot_area'],
            'acceptable_land_rights' => json_encode($validated['acceptable_land_rights']),
            'setback_compliance_required' => $validated['setback_compliance_required'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if ($inserted) {
            return response()->json(['message' => 'Rule created successfully'], 201);
        }

        return response()->json(['message' => 'Failed to create rule'], 500);
    }

    // Update an existing rule
    public function update(Request $request, $id)
    {
        $rule = DB::table('rules')->where('id', $id)->first(); // Get the existing rule by ID
        if (!$rule) {
            return response()->json(['message' => 'Rule not found'], 404);
        }

        $validated = $request->validate([
            'required_area' => 'required|integer',
            'allowed_zones' => 'required|array',
            'minimum_lot_area' => 'required|integer',
            'acceptable_land_rights' => 'required|array',
            'setback_compliance_required' => 'required|boolean',
        ]);

        // Update the rule data in 'rules' table using DB facade
        $updated = DB::table('rules')->where('id', $id)->update([
            'required_area' => $validated['required_area'],
            'allowed_zones' => json_encode($validated['allowed_zones']),
            'minimum_lot_area' => $validated['minimum_lot_area'],
            'acceptable_land_rights' => json_encode($validated['acceptable_land_rights']),
            'setback_compliance_required' => $validated['setback_compliance_required'],
            'updated_at' => now(),
        ]);

        if ($updated) {
            return response()->json(['message' => 'Rule updated successfully']);
        }

        return response()->json(['message' => 'Failed to update rule'], 500);
    }

    // Delete a rule
    public function deleteRules($id)
    {
        $rule = DB::table('rules')->where('id', $id)->first(); // Get the existing rule by ID
        if (!$rule) {
            return response()->json(['message' => 'Rule not found'], 404);
        }

        // Delete the rule using DB facade
        $deleted = DB::table('rules')->where('id', $id)->delete();
        if ($deleted) {
            return response()->json(['message' => 'Rule deleted successfully']);
        }

        return response()->json(['message' => 'Failed to delete rule'], 500);
    }
}
