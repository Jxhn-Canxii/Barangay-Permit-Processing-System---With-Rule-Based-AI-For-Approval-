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

        $query = User::query();

        // Apply search filter if provided
        if ($search) {
            $query->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
        }

        // Get total records before pagination
        $total = $query->count();

        // Sort by latest ID first and apply manual pagination
        $users = $query->orderBy('id', 'desc')->skip($offset)->take($itemsPerPage)->get();

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

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('status', 'User added successfully.');
    }
    public function deleteUser($id)
    {
        $deleted = DB::table('users')->where('id', $id)->delete();

        if ($deleted) {
            return response()->json(['message' => 'User deleted successfully!']);
        }

        return response()->json(['message' => 'Failed to delete record.'], 500);
    }
}
