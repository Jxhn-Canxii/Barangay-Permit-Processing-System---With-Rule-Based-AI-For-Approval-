<?php

namespace App\Http\Controllers;

use App\Services\PermitPredictionService; // Include the PermitPredictionService
use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

//ai

//mailer
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
        $userRole = $request->user()->role; // Get session user ID
    
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
    
        //total count
        $allPermitsList = DB::table('zoning_permits');

        $allPermitsList->where('status_id', 2);
        if ($userRole == 3) {
            
            $allPermitsList->where('inputted_by', $userId);
        }
        
        $queryCount = $allPermitsList->get();
        
        $total = $queryCount->count();
    
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
        $userRole = $request->user()->role; // Get session user ID
    
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
    
        //total count
        $allPermitsList = DB::table('zoning_permits');

        $allPermitsList->where('status_id', 1);
        if ($userRole == 3) {
            
            $allPermitsList->where('inputted_by', $userId);
        }
        
        $queryCount = $allPermitsList->get();
        
        $total = $queryCount->count();
    
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
        $userRole = $request->user()->role; // Get session user ID
    
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
    
        //total count
        $allPermitsList = DB::table('zoning_permits');

        $allPermitsList->where('status_id', 3);
        if ($userRole == 3) {
            
            $allPermitsList->where('inputted_by', $userId);
        }
        
        $queryCount = $allPermitsList->get();
        
        $total = $queryCount->count();
    
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

        $request->merge([
            'existing_structures' => $request->has('existing_structures') ? filter_var($request->existing_structures, FILTER_VALIDATE_BOOLEAN) : false,
            'setback_compliance' => $request->has('setback_compliance') ? filter_var($request->setback_compliance, FILTER_VALIDATE_BOOLEAN) : false,
        ]);
        
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
            'zoning_district' => 'required|integer|min:0',
            'proposed_use' => 'required|string|max:255',
            'existing_structures' => 'boolean', // No need for required since we default it
            'setback_compliance' => 'boolean', // No need for required since we default it
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png',
        ]);
        

        
        $filePath = null;
        if ($request->hasFile('file')) {
            // Store the file in storage/app/zoning_permits
            $filePath = $request->file('file')->store('zoning_permits');  // No 'public' disk here, just 'zoning_permits'
        }

      

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
            'existing_structures' => (Boolean) $request->existing_structures,
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
    public function trainModel() {

       $trainModel = $this->predictionService->trainModel();

       return response()->json($trainModel);
    }
    //approve zoning with ai decision making using PHP AI
    public function decideByAI(Request $request, $id)
    {
        // Get zoning permit details
        $permit = DB::table('zoning_permits')
            ->where('id', $id)
            ->first([
                'date_of_application',
                'or_date',
                'official_receipt_no',
                'first_name',
                'middle_name',
                'last_name',
                'address',
                'zip',
                'owner_name',
                'contact_number',
                'email',
                'location_of_lot',
                'right_over_land',
                'lot_area',
                'zoning_district',
                'proposed_use',
                'existing_structures',
                'setback_compliance'
            ]);
    
        if (!$permit) {
            return response()->json(['message' => 'Permit not found'], 404);
        }
    
        try {
            // Ensure prediction service is initialized
            if (!isset($this->predictionService)) {
                throw new \Exception("Prediction service is not initialized.");
            }
    
            // Convert permit object to an array
            $permitArray = (array) $permit;
    
            // Get prediction result
            $prediction =  $this->predictionService->predict($permitArray);
            $predictionStatus = $prediction['status'];
            $predictionMessage = $prediction['message'];

            // Log input data for debugging
            $logData = [
                'timestamp' => now()->toDateTimeString(),
                'feature_count' => count($permitArray),
                'expected_features' => 24,
                'input' => $permitArray,
                'prediction' => $prediction,
            ];
    
            file_put_contents(storage_path('app/prediction/predict_log.json'), json_encode($logData, JSON_PRETTY_PRINT));
    
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Prediction failed',
                'error' => $e->getMessage(),
            ], 500);
        }

        // Ensure prediction result is valid
        if (!in_array($predictionStatus, [2, 3])) {
            return response()->json([
                'message' => 'Invalid prediction result',
                'prediction' => $predictionStatus
            ], 500);
        }
    
        // Approve or reject the permit
        $status = ($predictionStatus === 2) ? 2 : 3;
        $approvalStatus = ($predictionStatus != 2);
        $message = ($predictionStatus === 2) ? "Approved" : "Rejected, Reason: ".$predictionMessage;
        $emailClass = ($predictionStatus === 2) ? ZoningPermitApproved::class : ZoningPermitRejected::class;
    
        DB::table('zoning_permits')->where('id', $id)->update([
            'status_id' => $status,
            'rejection_reason' => $predictionMessage,
            'updated_at' => now(),
        ]);
    
        // Log approval decision
        $logMessage = "{$message} zoning permit for {$permit->first_name} {$permit->last_name}";
        file_put_contents(storage_path('app/prediction/approval_log.json'), json_encode([
            'timestamp' => now()->toDateTimeString(),
            'message' => $logMessage
        ], JSON_PRETTY_PRINT));
    
        // Send email
        try {
            if (!empty($permit->email)) {
                Mail::to($permit->email)->send(new $emailClass($permit));
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => $status,
                'message' => "Zoning permit {$message}, but email notification failed.",
                'error' => $e->getMessage(),
            ], 200);
        }
    
        return response()->json(['status' => $status, 'message' => "Zoning permit {$message} and email sent"], 200);
    }
    //approve zoning with ai decision making using Phyton PyPanda Machine Learning
    public function decideByAIV2(Request $request, $id)
    {
        // Get zoning permit details
        $permit = DB::table('zoning_permits')
            ->where('id', $id)
            ->first([
                'right_over_land',
                'zoning_district',
                'proposed_use',
                'existing_structures',
                'setback_compliance',
                'lot_area',
            ]);

        if (!$permit) {
            return response()->json(['message' => 'Permit not found'], 404);
        }

        // Convert the permit object to an array
        $permitArray = (array) $permit;

        // Encode data as JSON
        $inputJson = json_encode($permitArray);

        // Define the path to your Python script
        $pythonScriptPath = base_path('ml/predict_zoning.py');

        // Execute the Python script
        $command = "python3 " . escapeshellarg($pythonScriptPath) . " " . escapeshellarg($inputJson);
        $output = shell_exec($command);

        // Decode the output
        $prediction = json_decode($output, true)['status_id'] ?? null;

        if (!$prediction) {
            return response()->json(['message' => 'AI prediction failed', 'error' => $output], 500);
        }

        // Determine approval status
        $status = ($prediction === 2) ? 2 : 3;
        $message = ($status === 2) ? "Approved" : "Rejected";

        // Update the zoning permit status
        DB::table('zoning_permits')->where('id', $id)->update([
            'status_id' => $status,
            'updated_at' => now(),
        ]);

        return response()->json(['status' => $status, 'message' => "Zoning permit {$message}"], 200);
    }

    //approve zoning without ai intervention
    public function approve(Request $request, $id)
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
        //on database Own,Rent,Inherited
        return match(strtolower($right)) {
            'own'     => 1,
            'rent'    => 2,
            'inherited' => 3,
            default     => 0
        };
    }

    private function encodeZoneType($zone)
    {
        //on database Residential,commercial,industrial
        return match(strtolower($zone)) {
            'residential' => 1,
            'commercial' => 2,
            'industrial' => 3,
            default => 0,
        };
    }

    private function encodeProposedUse($use)
    {
        // On database: single-family, multi-family, retail, office, mixed-use
        return match(strtolower($use)) {
            'single-family' => 1,
            'multi-family' => 2,
            'retail' => 3,
            'office' => 4,
            'mixed-use' => 5,
            default => 0,
        };
    }

    private function fallbackDecision($input)
    {
        // Example rules: If industrial zone and has a large lot, approve
        if ($input['zoning_district'] === 3 && $input['lot_area'] === 3) {
            return 2; // Approved
        }

        // If residential zone and setback is non-compliant, reject
        if ($input['zoning_district'] === 1 && $input['setback_compliance'] === 0) {
            return 3; // Rejected
        }

        // Default: Reject if no AI model is available
        return 3;
    }


    public function viewImage($filename)
    {
        // Define the path to the file within the 'zoning_permits' directory
        $path = 'zoning_permits/' . $filename;
    
        // Ensure the file exists in storage
        if (Storage::disk('local')->exists($path)) {
            // Get the file content
            $file = Storage::disk('local')->get($path);
    
            // Get the file's MIME type
            $mimeType = Storage::disk('local')->mimeType($path);
    
            // Return the file with the appropriate content type
            return response($file, 200)
                ->header('Content-Type', $mimeType);
        } else {
            // If the file doesn't exist, return a 404 response
            abort(404);
        }
    }

}
