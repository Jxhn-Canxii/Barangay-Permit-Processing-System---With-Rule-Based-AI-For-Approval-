<?php

namespace App\Services;

use Illuminate\Http\Request;


///rule based AI
class PermitPredictionService
{
    private $logPath;

    public function __construct()
    {
        $this->logPath = storage_path('app/prediction/logs.json');
    }

    // Function to log prediction details to a JSON log file
    private function logData(array $data)
    {
        $logEntries = file_exists($this->logPath) ? json_decode(file_get_contents($this->logPath), true) : [];
        $logEntries[] = $data;
        file_put_contents($this->logPath, json_encode($logEntries, JSON_PRETTY_PRINT));
    }

    // Function to define rules and predict zoning permit approval
    public function predict(array $data)
    {
        // Define the rules for zoning permit approval
        $rules = [
            'required_area' => 500, // Minimum required area (e.g., 500 sq. meters)
            'allowed_zones' => ['residential', 'commercial', 'industrial'], // Allowed zoning types
            'minimum_lot_area' => 100, // Minimum lot area in square meters for certain uses
            'acceptable_land_rights' => [1, 3], // Only 'Own' (1) and 'Inherited' (3) land rights are allowed
            'setback_compliance_required' => true, // Setback compliance is mandatory
        ];
    
        // Initialize log data
        $logData = [
            'timestamp' => now()->toDateTimeString(),
            'status' => 3, // Denied by default
            'message' => 'Test'
        ];
    
        // Initialize an empty array to store reasons for denial
        $reasons = [];
    
        // Rule 1: Check if the land right is valid
        if (!in_array($data['right_over_land'], $rules['acceptable_land_rights'])) {
            $reasons[] = 'Invalid land right';
        }
    
        // Rule 2: Check if the lot area is large enough
        if ($data['lot_area'] < $rules['required_area']) {
            $reasons[] = 'Lot area too small';
        }
    
        // Rule 3: Check if the proposed use matches zoning district
        if (!in_array(strtolower($data['zoning_district']), $rules['allowed_zones'])) {
            $reasons[] = 'Zoning district does not allow proposed use';
        }
    
        // Rule 4: Check setback compliance
        if ($rules['setback_compliance_required'] && !$data['setback_compliance']) {
            $reasons[] = 'Setback non-compliant';
        }
    
        // Rule 5: Check if the proposed use is allowed in the zoning district
        if ($data['zoning_district'] == 'residential' && in_array(strtolower($data['proposed_use']), ['retail', 'office', 'mixed-use'])) {
            $reasons[] = 'Proposed use not allowed in residential zone';
        }
    
        // Rule 6: Ensure the proposed use fits zoning requirements (optional additional rule)
        if ($data['zoning_district'] == 'commercial' && $data['proposed_use'] == 'single-family') {
            $reasons[] = 'Single-family use not allowed in commercial zone';
        }
    
        // If there are reasons for denial, append them
        if (count($reasons) > 0) {
            $logData['message'] = 'Denied: ' . implode(', ', $reasons);
        } else {
            // If no reasons for denial, approve the permit
            $logData['message'] = 'Approved';
            $logData['status'] = 2; // Approved status
        }
    
        // Log the decision and the reasons
        $this->logData($logData);
    
        return $logData;
    }
    
}
