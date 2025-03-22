<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class UserController extends Controller
{
    // Renders the User Management Page without the user list
    public function index()
    {
        return Inertia::render('Admin/Users/Index', [
            'status' => session('status'),
        ]);
    }

    // Fetch user list separately (API response)
    public function list(Request $request)
    {
        $search = $request->input('search', '');
        $itemsPerPage = (int) $request->input('itemsperpage', 10);
        $page = (int) $request->input('page_num', 1);
        $offset = ($page - 1) * $itemsPerPage;

        $query = DB::table('users');

        // Apply search filter if provided
        if ($search) {
            $query->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
        }

        // Get total records before pagination
        $total = $query->count();

        // Sort by latest ID first and apply manual pagination
        $users = $query->orderBy('id', 'desc')
                        ->skip($offset)
                        ->take($itemsPerPage)
                        ->get();

        return response()->json([
            'users' => $users,
            'total' => $total,
            'total_pages' => ceil($total / $itemsPerPage),
            'page_num' => $page,
            'itemsperpage' => $itemsPerPage,
        ]);
    }

    // Add a new user
    public function add(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|integer|in:1,2,3', // Adjust roles as needed
        ]);

        // Insert user using DB facade
        DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('users.index')->with('status', 'User added successfully.');
    }

    // Update user using DB facade
    public function update(Request $request, $id)
    {
        
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email', // Ensure unique email but ignore current user
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()], // Password is optional on update
            'role' => 'required|integer|in:1,2,3', // Adjust roles as needed
        ]);

        // Check if the user exists in the database using DB facade
        $user = DB::table('users')->where('id', $id)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        // Prepare updated data
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'updated_at' => now(),
        ];

        // Update password only if provided
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        // Update the user using DB facade
        DB::table('users')->where('id', $id)->update($data);

        return response()->json(['message' => 'User updated successfully.']);
    }

    // Delete user using DB facade
    public function deleteUser($id)
    {
        // Delete the user using DB facade
        $deleted = DB::table('users')->where('id', $id)->delete();

        if ($deleted) {
            return response()->json(['message' => 'User deleted successfully!']);
        }

        return response()->json(['message' => 'Failed to delete record.'], 500);
    }
}
