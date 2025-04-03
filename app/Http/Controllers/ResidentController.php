<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class ResidentController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Residents/Index', [
            'status' => session('status'),
        ]);
    }

    // Fetch the list of residents
    public function list(Request $request)
    {
        // Fetch search query, items per page, and page number
        $search = $request->input('search', '');
        $itemsPerPage = (int) $request->input('itemsperpage', 10);
        $page = (int) $request->input('page_num', 1);
        $offset = ($page - 1) * $itemsPerPage;

        // Query for the residents table
        $query = DB::table('residents');

        // Apply search filter if provided
        if ($search) {
            $query->where('firstname', 'like', "%$search%")
                ->orWhere('lastname', 'like', "%$search%")
                ->orWhere('city', 'like', "%$search%")
                ->orWhere('barangay', 'like', "%$search%");
        }

        // Get total records before pagination
        $total = $query->count();

        // Sort by the latest ID first and apply manual pagination
        $residents = $query->orderBy('id', 'desc')
                            ->skip($offset)
                            ->take($itemsPerPage)
                            ->get();

        return response()->json([
            'residents' => $residents,
            'total' => $total,
            'total_pages' => ceil($total / $itemsPerPage),
            'page_num' => $page,
            'itemsperpage' => $itemsPerPage,
        ]);
    }

    // Create Resident
    public function add(Request $request)
    {
        // Validate the incoming data
        $validator = Validator::make($request->all(), [
            'date_of_census' => 'required|date',
            'area_of_census_street' => 'required|string',
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'last_name' => 'required|string',
            'birthday' => 'required|date',
            'age' => 'required|integer',
            'gender' => 'required|string',
            'civil_status' => 'required|string',
            'current_school_enrollment' => 'required|string',
            'educational_attainment' => 'required|string',
            'employment_status' => 'required|string',
            'occupation' => 'required|string',
            'house_number' => 'required|integer',
            'street_name' => 'required|string',
            'barangay' => 'required|string',
            'city' => 'required|string',
            'province' => 'required|string',
            'housing_type' => 'required|string',
            'health_status' => 'required|string',
            'disability_status' => 'required|string',
            'existing_health_condition' => 'nullable|string',
            'fully_immunized' => 'required|string',
            'covid_19_vaccination' => 'required|string',
            'housing_type' => 'required|string',
            'year_of_constructed' => 'required|integer',
            'resident_lived' => 'required|string',
            'mobile_number' => 'required|numeric',
            'emergency_contact_name' => 'required|string',
            'emergency_contact_number' => 'required|numeric',
            'relationship_to_emergency_contact' => 'required|string',
            'number_of_house_members' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Map snake_case keys to camelCase for database insert
        $residentData = [
            'dateofcencus' => $request->date_of_census,
            'areaofcencusstreet' => $request->area_of_census_street,
            'firstname' => $request->first_name,
            'middlename' => $request->middle_name,
            'lastname' => $request->last_name,
            'birthday' => $request->birthday,
            'age' => $request->age,
            'gender' => $request->gender,
            'civilstatus' => $request->civil_status,
            'currentschoolenrollment' => $request->current_school_enrollment,
            'educationalattainment' => $request->educational_attainment,
            'employmentstatus' => $request->employment_status,
            'occupation' => $request->occupation,
            'housenumber' => $request->house_number,
            'streetname' => $request->street_name,
            'barangay' => $request->barangay,
            'city' => $request->city,
            'province' => $request->province,
            'housetype' => $request->housing_type,
            'healthstatus' => $request->health_status,
            'disabilitystatus' => $request->disability_status,
            'existinghealthcondition' => $request->existing_health_condition,
            'fullyimmunized' => $request->fully_immunized,
            'covid19vaccination' => $request->covid_19_vaccination,
            'housingtype' => $request->housing_type,
            'yearofconstructed' => $request->year_of_constructed,
            'residentlived' => $request->resident_lived,
            'mobilenumber' => $request->mobile_number,
            'emergencycontactname' => $request->emergency_contact_name,
            'emergencycontactnumber' => $request->emergency_contact_number,
            'relationshiptoemergencycontact' => $request->relationship_to_emergency_contact,
            'numberofhousemembers' => $request->number_of_house_members,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Insert data into the database
        $resident = DB::table('residents')->insertGetId($residentData);

        return response()->json(['message' => 'Resident created successfully!', 'resident_id' => $resident], 201);
    }


    // Read Resident (single)
    public function show($id)
    {
        $resident = DB::table('residents')->where('id', $id)->first();

        if (!$resident) {
            return response()->json(['message' => 'Resident not found'], 404);
        }

        return response()->json(['resident' => $resident], 200);
    }

    // Update Resident
    public function update(Request $request, $id)
    {
        // Validate incoming data
        $validator = Validator::make($request->all(), [
            'date_of_census' => 'required|date',
            'area_of_census_street' => 'required|string',
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'last_name' => 'required|string',
            'birthday' => 'required|date',
            'age' => 'required|integer',
            'gender' => 'required|string',
            'civil_status' => 'required|string',
            'current_school_enrollment' => 'required|string',
            'educational_attainment' => 'required|string',
            'employment_status' => 'required|string',
            'occupation' => 'required|string',
            'house_number' => 'required|integer',
            'street_name' => 'required|string',
            'barangay' => 'required|string',
            'city' => 'required|string',
            'province' => 'required|string',
            'housing_type' => 'required|string',
            'health_status' => 'required|string',
            'disability_status' => 'required|string',
            'existing_health_condition' => 'nullable|string',
            'fully_immunized' => 'required|string',
            'covid_19_vaccination' => 'required|string',
            'housing_type' => 'required|string',
            'year_of_constructed' => 'required|integer',
            'resident_lived' => 'required|string',
            'mobile_number' => 'required|numeric',
            'emergency_contact_name' => 'required|string',
            'emergency_contact_number' => 'required|numeric',
            'relationship_to_emergency_contact' => 'required|string',
            'number_of_house_members' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Map snake_case request data to camelCase database columns
        $updated = DB::table('residents')->where('id', $id)->update([
            'dateofcencus' => $request->date_of_census,
            'areaofcencusstreet' => $request->area_of_census_street,
            'firstname' => $request->first_name,
            'middlename' => $request->middle_name,
            'lastname' => $request->last_name,
            'birthday' => $request->birthday,
            'age' => $request->age,
            'gender' => $request->gender,
            'civilstatus' => $request->civil_status,
            'currentschoolenrollment' => $request->current_school_enrollment,
            'educationalattainment' => $request->educational_attainment,
            'employmentstatus' => $request->employment_status,
            'occupation' => $request->occupation,
            'housenumber' => $request->house_number,
            'streetname' => $request->street_name,
            'barangay' => $request->barangay,
            'city' => $request->city,
            'province' => $request->province,
            'housetype' => $request->housing_type,
            'healthstatus' => $request->health_status,
            'disabilitystatus' => $request->disability_status,
            'existinghealthcondition' => $request->existing_health_condition,
            'fullyimmunized' => $request->fully_immunized,
            'covid19vaccination' => $request->covid_19_vaccination,
            'housingtype' => $request->housing_type,
            'yearofconstructed' => $request->year_of_constructed,
            'residentlived' => $request->resident_lived,
            'mobilenumber' => $request->mobile_number,
            'emergencycontactname' => $request->emergency_contact_name,
            'emergencycontactnumber' => $request->emergency_contact_number,
            'relationshiptoemergencycontact' => $request->relationship_to_emergency_contact,
            'numberofhousemembers' => $request->number_of_house_members,
            'updated_at' => now(),
        ]);

        if ($updated) {
            return response()->json(['message' => 'Resident updated successfully'], 200);
        }

        return response()->json(['message' => 'Resident not found'], 404);
    }

    // Delete Resident
    public function deleteResident($id)
    {
        // Delete the resident record
        $deleted = DB::table('residents')->where('id', $id)->delete();

        if ($deleted) {
            return response()->json(['message' => 'Resident deleted successfully'], 200);
        }

        return response()->json(['message' => 'Resident not found'], 404);
    }
}
