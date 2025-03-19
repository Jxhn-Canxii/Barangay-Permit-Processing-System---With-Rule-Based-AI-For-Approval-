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
            'or_date' => 'required|date',
            'official_receipt_no' => 'required|string|max:255|unique:zoning_permits',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'zip' => 'nullable|string|max:10',
            'owner_name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'location_of_lot' => 'required|string|max:255',
            'right_over_land' => 'required|string|max:50',
            'lot_area' => 'required|string|max:50',
            'zoning_district' => 'required|string|in:residential,commercial,industrial',
            'proposed_use' => 'required|string|max:255',
            'existing_structures' => 'required|integer|min:0',
            'setback_compliance' => 'required|string',
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
            'zoning_district' => $request->zoning_district,
            'proposed_use' => $request->proposed_use,
            'existing_structures' => $request->existing_structures,
            'setback_compliance' => (Boolean) $request->setback_compliance,
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
    
    //approve zoning with ai decision making
    public function approve(Request $request, $id)
    {
        $userId = $request->user()->id;

        // Get all required fields for prediction
        $permit = DB::table('zoning_permits')
            ->where('id', $id)
            ->first([
                'zip',
                'right_over_land',
                'lot_area',
                'zoning_district',
                'proposed_use',
                'existing_structures',
                'setback_compliance',
                'first_name',
                'last_name',
                'email'
            ]);

        if (!$permit) {
            return response()->json(['message' => 'Permit not found'], 404);
        }

        // Prepare input data for prediction
        $input = [
            (int) $this->normalizeZip($permit->zip),
            (int) $this->encodeLandRight($permit->right_over_land),
            (float) $permit->lot_area,
            (int) $this->encodeZoneType($permit->zoning_district),
            (int) $this->encodeProposedUse($permit->proposed_use),
            (int) $permit->existing_structures,
            (int) $permit->setback_compliance
        ];

        try {
            // Ensure prediction service is working
            if (!isset($this->predictionService)) {
                throw new \Exception("Prediction service is not initialized.");
            }

            // Debug: Log input for prediction
            \Log::info("Prediction Input: ", $input);

            // Get prediction
            $prediction = $this->predictionService->predict($input);

            // Debug: Log prediction output
            \Log::info("Prediction Output: ", $prediction);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Prediction failed',
                'error' => $e->getMessage(),
            ], 500);
        }

        // Handle prediction result
        if ($prediction[0] === 'approved') {
            DB::table('zoning_permits')->where('id', $id)->update([
                'status_id' => 2,
                'updated_at' => now(),
            ]);

            // Log the transaction
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
            // Handle rejection case
            $message = "Rejected zoning permit for {$permit->first_name} {$permit->last_name}";
            $this->logs($userId, "Zoning Application", $message);

            // Send rejection email
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
    }

    //approve zoning without ai intervention
    public function approvev1(Request $request, $id)
    {
        $userId = $request->user()->id;
    
        $permit = DB::table('zoning_permits')->where('id', $id)->first(['first_name', 'last_name', 'email']);
    
        if (!$permit) {
            return response()->json(['message' => 'Permit not found'], 404);
        }
    
        // Update permit status
        DB::table('zoning_permits')->where('id', $id)->update([
            'status_id' => 2,
            'updated_at' => now(),
        ]);
    
        // Log the transaction
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
    
        /**
     * Sends a zoning permit email based on status.
     */
    private function sendPermitEmail($permit, $status)
    {
        if (empty($permit->email)) {
            return response()->json(['message' => "Zoning permit {$status}, but no email provided"], 200);
        }
    
        try {
            $emailClass = ($status === 'approved') ? ZoningPermitApproved::class : ZoningPermitRejected::class;
            Mail::to($permit->email)->send(new $emailClass($permit));
    
            return response()->json(['message' => "Zoning permit {$status} and email sent"], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Zoning permit {$status}, but email notification failed.",
                'error' => $e->getMessage(),
            ], 200);
        }
    }
    
    private function normalizeZip($zip)
    {
        return (int) substr(preg_replace('/[^0-9]/', '', $zip), 0, 3);
    }

    private function encodeLandRight($right)
    {
        return match(strtolower($right)) {
            'owned'     => 0,
            'leased'    => 1,
            'inherited' => 2,
            default     => 0
        };
    }

    private function encodeZoneType($zone)
    {
        return match(strtolower($zone)) {
            'residential' => 0,
            'commercial'  => 1,
            'industrial'  => 2,
            default       => 0
        };
    }

    private function encodeProposedUse($use)
    {
        return match(strtolower($use)) {
            'single-family' => 0,
            'multi-family'  => 1,
            'retail'        => 2,
            'office'        => 3,
            default         => 0
        };
    }
}
