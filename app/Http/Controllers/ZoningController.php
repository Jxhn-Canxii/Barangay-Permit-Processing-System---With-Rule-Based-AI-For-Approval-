<?php

namespace App\Http\Controllers;

use App\Services\PermitPredictionService; // Include the PermitPredictionService
use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use App\Mail\ZoningPermitApproved;
use App\Mail\ZoningPermitRejected;
use Illuminate\Support\Facades\Mail;

class ZoningController extends Controller
{

    protected $predictionService;

    public function __construct(PermitPredictionService $predictionService)
    {
        $this->predictionService = $predictionService;
    }

    public function index()
    {
        return Inertia::render('Admin/Zoning/Index', [
            'status' => session('status'),
        ]);
    }

    public function map()
    {
        return Inertia::render('Admin/ZonalMap/Index', [
            'status' => session('status'),
        ]);
    }
    // status legend....
    // 1 = pending
    // 2 = approved
    // 3 = rejected
    public function listApproved(Request $request)
    {
        $search = $request->input('search', '');
        $itemsPerPage = $request->input('itemsperpage', 10);
        $page = $request->input('page_num', 1);
        $offset = ($page - 1) * $itemsPerPage;
    
        $userId = $userId = $request->user()->id; // Get session user ID
        $userRole = DB::table('users')->where('id', $userId)->value('role'); // Get user role
    
        $query = DB::table('zoning_permits')
            ->where('status_id', 2)
            ->where(function ($query) use ($search) {
                $query->where('first_name', 'LIKE', "%$search%")
                    ->orWhere('middle_name', 'LIKE', "%$search%")
                    ->orWhere('last_name', 'LIKE', "%$search%")
                    ->orWhere('location_of_lot', 'LIKE', "%$search%");
            });
    
        // If user is not an admin (role == 3), only show their requests
        if ($userRole == 3) {
            $query->where('inputted_by', $userId);
        }
    
        // Apply sorting and pagination
        $permits = $query->orderBy('updated_at', 'desc')
            ->offset($offset)
            ->limit($itemsPerPage)
            ->get();
    
        $total = $query->count();
    
        return response()->json([
            'data' => $permits,
            'total' => $total,
            'total_pages' => ceil($total / $itemsPerPage),
            'page_num' => $page,
            'itemsperpage' => $itemsPerPage,
            'search' => $search,
        ]);
    }
    
    public function listPending(Request $request)
    {
        $search = $request->input('search', '');
        $itemsPerPage = $request->input('itemsperpage', 10);
        $page = $request->input('page_num', 1);
        $offset = ($page - 1) * $itemsPerPage;
    
        $userId = $userId = $request->user()->id; // Get session user ID
        $userRole = DB::table('users')->where('id', $userId)->value('role'); // Get user role
    
        $query = DB::table('zoning_permits')
            ->where('status_id', 1)
            ->where(function ($query) use ($search) {
                $query->where('first_name', 'LIKE', "%$search%")
                    ->orWhere('middle_name', 'LIKE', "%$search%")
                    ->orWhere('last_name', 'LIKE', "%$search%")
                    ->orWhere('location_of_lot', 'LIKE', "%$search%");
            });
    
        // If user is not an admin (role == 3), only show their requests
        if ($userRole == 3) {
            $query->where('inputted_by', $userId);
        }
    
        $permits = $query->orderBy('created_at', 'desc')
            ->offset($offset)
            ->limit($itemsPerPage)
            ->get();
    
        $total = $query->count();
    
        return response()->json([
            'data' => $permits,
            'total' => $total,
            'total_pages' => ceil($total / $itemsPerPage),
            'page_num' => $page,
            'itemsperpage' => $itemsPerPage,
            'search' => $search,
        ]);
    }
    
    public function listRejected(Request $request)
    {
        $search = $request->input('search', '');
        $itemsPerPage = $request->input('itemsperpage', 10);
        $page = $request->input('page_num', 1);
        $offset = ($page - 1) * $itemsPerPage;
    
        $userId = $userId = $request->user()->id; // Get session user ID
        $userRole = DB::table('users')->where('id', $userId)->value('role'); // Get user role
    
        $query = DB::table('zoning_permits')
            ->where('status_id', 3)
            ->where(function ($query) use ($search) {
                $query->where('first_name', 'LIKE', "%$search%")
                      ->orWhere('middle_name', 'LIKE', "%$search%")
                      ->orWhere('last_name', 'LIKE', "%$search%")
                      ->orWhere('location_of_lot', 'LIKE', "%$search%");
            });
    
        // If user is not an admin (role == 3), only show their requests
        if ($userRole == 3) {
            $query->where('inputted_by', $userId);
        }
    
        $permits = $query->orderBy('created_at', 'desc')
            ->offset($offset)
            ->limit($itemsPerPage)
            ->get();
    
        $total = $query->count();
    
        return response()->json([
            'data' => $permits,
            'total' => $total,
            'total_pages' => ceil($total / $itemsPerPage),
            'page_num' => $page,
            'itemsperpage' => $itemsPerPage,
            'search' => $search,
        ]);
    }
 
    public function add(Request $request)
    {
        $userId = $request->user()->id;

        $request->validate([
            'date_of_application' => 'required|date',
            'or_date' => 'nullable|date',
            'official_receipt_no' => 'required|string|max:255|unique:zoning_permits',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'zip' => 'nullable|string|max:10',
            'owner_name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'location_of_lot' => 'required|string|max:255',
            'right_over_land' => 'required|string|max:50',
            'lot_area' => 'required|string|max:50',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);
       
        // Store the uploaded file
        $filePath = $request->file('file')->store('zoning_permits', 'public');

        // Insert into database
        DB::table('zoning_permits')->insert([
            'date_of_application' => $request->date_of_application,
            'or_date' => $request->or_date,
            'official_receipt_no' => $request->official_receipt_no,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'zip' => $request->zip,
            'owner_name' => $request->owner_name,
            'contact_number' => $request->contact_number,
            'email' => $request->email,
            'location_of_lot' => $request->location_of_lot,
            'right_over_land' => $request->right_over_land,
            'lot_area' => $request->lot_area,
            'uploaded_file' => $filePath,
            'status_id' => 1,
            'inputted_by' => $userId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Log the transaction
        $message = "Added zoning permit for {$request->first_name} {$request->last_name}";
        $this->logs($userId, "Zoning Application", $message);

        return response()->json(['message' => 'Zoning permit submitted successfully'], 201);
    }

    public function approve(Request $request, $id)
    {
        $userId = $request->user()->id;

        // Get the permit details
        $permit = DB::table('zoning_permits')->where('id', $id)->first(['first_name', 'last_name', 'email', 'location_of_lot', 'lot_area']);
        
        if (!$permit) {
            return response()->json(['message' => 'Permit not found'], 404);
        }

        // Predict the status based on the permit data
        $prediction = $this->predictionService->predict([
            $permit->location_of_lot, 
            $permit->lot_area
        ]);

        // If the model predicts 'approved', proceed with approval
        if ($prediction[0] == 2) {
            DB::table('zoning_permits')->where('id', $id)->update([
                'status_id' => 2,
                'updated_at' => now(),
            ]);

            // Log the action
            $message = "Approved zoning permit for {$permit->first_name} {$permit->last_name}";
            $this->logs($userId, "Zoning Application", $message);

            // Send email notification
            try {
                if (!empty($permit->email)) {
                    Mail::to($permit->email)->send(new ZoningPermitApproved($permit));
                }
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Zoning permit approved, but email notification failed.',
                    'error' => $e->getMessage(),
                ], 200);
            }

            return response()->json(['message' => 'Zoning permit approved and email sent'], 200);
        } else {
            return response()->json(['message' => 'Permit prediction rejected, status remains pending.'], 400);
        }
    }
    
    public function reject(Request $request, $id)
    {
        $userId = $request->user()->id;
    
        $permit = DB::table('zoning_permits')->where('id', $id)->first(['first_name', 'last_name', 'email']);
    
        if (!$permit) {
            return response()->json(['message' => 'Permit not found'], 404);
        }
    
        // Update permit status
        DB::table('zoning_permits')->where('id', $id)->update([
            'status_id' => 3,
            'updated_at' => now(),
        ]);
    
        // Log the transaction
        $message = "Rejected zoning permit for {$permit->first_name} {$permit->last_name}";
        $this->logs($userId, "Zoning Application", $message);
    
        // Send email notification
        try {
            if (!empty($permit->email)) {
                Mail::to($permit->email)->send(new ZoningPermitRejected($permit));
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Zoning permit rejected, but email notification failed.',
                'error' => $e->getMessage(),
            ], 200);
        }
    
        return response()->json(['message' => 'Zoning permit rejected and email sent'], 200);
    }
    public function logs($userId, $module, $message)
    {
        DB::table('logs')->insert([
            'user_id' => $userId,
            'module' => $module,
            'action' => $message,
            'created_at' => now(),
        ]);
    }

}
