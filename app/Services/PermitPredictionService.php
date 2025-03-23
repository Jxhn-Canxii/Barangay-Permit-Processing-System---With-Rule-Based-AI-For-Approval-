<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        // Retrieve the relevant rule from the database based on the zoning district
        $rule = DB::table('rules')
            ->where('zoning_district', $data['zoning_district'])
            ->first();
    
        // Check if the rule exists
        if (!$rule) {
            // If no rule found for the given zoning district, deny the permit
            return [
                'status' => 3,
                'message' => 'Zoning district not found in the rules table'
            ];
        }
    
        // Initialize log data
        $logData = [
            'timestamp' => now()->toDateTimeString(),
            'status' => 3, // Denied by default
            'message' => 'Test'
        ];
    
        // Initialize an empty array to store reasons for denial
        $reasons = [];
    
        // Remove brackets and convert the string into an array
        $acceptableLandRights = explode(',', trim($rule->acceptable_land_rights, '[]'));

        // Rule 1: Check if the land right is valid
        if (!in_array($data['right_over_land'], $acceptableLandRights, true)) {
            $reasons[] = 'Invalid land right';
        }

    
        // Rule 2: Check if the lot area is large enough to the required max area
        if ($data['lot_area'] > $rule->maximum_lot_area) {
            $reasons[] = 'Lot area too big';
        }
    
        // Rule 3: Check if the lot area is less enough to the required min area
        if ($data['lot_area'] < $rule->minimum_lot_area) {
            $reasons[] = 'Lot area too small';
        }
    
        // Rule 4: Check setback compliance if required
        if ($rule->setback_compliance_required && !$data['setback_compliance']) {
            $reasons[] = 'Setback non-compliant';
        }
    
        // Rule 5: Ensure proposed use matches the zoning district (specific for residential zone)
        if ($data['zoning_district'] == 'residential' && in_array(strtolower($data['proposed_use']), ['retail', 'office', 'mixed-use'])) {
            $reasons[] = 'Proposed use not allowed in residential zone';
        }
    
        // Rule 6: Ensure proposed use fits zoning district (specific for commercial zone)
        if ($data['zoning_district'] == 'commercial' && $data['proposed_use'] == 'single-family') {
            $reasons[] = 'Single-family use not allowed in commercial zone';
        }
    
        // If there are reasons for denial, update the log message
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
