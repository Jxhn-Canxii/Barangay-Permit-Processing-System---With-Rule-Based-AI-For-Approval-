<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class LogsController extends Controller
{
    //
    public function index()
    {
        return Inertia::render('Admin/Logs/Index', [
            'status' => session('status'),
        ]);
    }

    public function listLogs(Request $request)
    {
        $search = $request->input('search', '');
        $itemsPerPage = $request->input('itemsperpage', 10);
        $page = $request->input('page_num', 1);
        $offset = ($page - 1) * $itemsPerPage;
    
        // Get authenticated user
        $user = auth()->user();
    
        // Query logs with user name from users table
        $query = DB::table('logs')
            ->join('users', 'logs.user_id', '=', 'users.id')
            ->select('logs.*', 'users.name as user_name')
            ->where(function ($query) use ($search) {
                $query->where('users.name', 'LIKE', "%$search%")
                    ->orWhere('logs.action', 'LIKE', "%$search%")
                    ->orWhere('logs.module', 'LIKE', "%$search%")
                    ->orWhere('logs.ip_address', 'LIKE', "%$search%")
                    ->orWhere('logs.details', 'LIKE', "%$search%");
            });
    
        // If user role is 3, show only their logs
        if ($user->role == 3) {
            $query->where('logs.user_id', $user->id);
        }
    
        // Fetch paginated results
        $logs = $query->orderBy('logs.created_at', 'desc')
            ->offset($offset)
            ->limit($itemsPerPage)
            ->get();
    
        // Get total count
        $total = $query->count();
    
        return response()->json([
            'logs' => $logs,
            'total' => $total,
            'total_pages' => ceil($total / $itemsPerPage),
            'page_num' => $page,
            'itemsperpage' => $itemsPerPage,
            'search' => $search,
        ]);
    }
    
    

}
