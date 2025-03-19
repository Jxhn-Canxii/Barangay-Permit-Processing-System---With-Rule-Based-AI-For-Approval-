<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Services\PermitPredictionService;

class TrainModelCommand extends Command
{
    protected $signature = 'model:train';
    protected $description = 'Retrain the zoning permit prediction model';

    public function handle()
    {
        $trainingData = DB::table('zoning_permits')
            ->whereIn('status_id', [2, 3]) // 2 = Approved, 3 = Rejected
            ->get()
            ->map(fn($permit) => [
                'inputs' => [
                    $this->normalizeZip($permit->zip),
                    $this->encodeLandRight($permit->right_over_land ?? 'owned'),
                    (float) ($permit->lot_area ?? 0), // Default to 0 if null
                    $this->encodeZoneType($permit->zoning_district ?? 'residential'),
                    $this->encodeProposedUse($permit->proposed_use ?? 'other'),
                    (int) ($permit->existing_structures ?? 0),
                    (int) ($permit->setback_compliance ?? 0)
                ],
                'labels' => $permit->status_id === 2 ? 'approved' : 'rejected'
            ]);

        if ($trainingData->isEmpty()) {
            $this->error('No valid training data found. Ensure zoning permits exist.');
            return;
        }

        $formatted = [
            'inputs' => $trainingData->pluck('inputs')->toArray(),
            'labels' => $trainingData->pluck('labels')->toArray()
        ];

        (new PermitPredictionService())->trainModel($formatted);

        $this->info("✅ Model training completed with " . count($formatted['inputs']) . " samples.");
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
            'warehouse'     => 4,
            'manufacturing' => 5,
            'agriculture'   => 6,
            'mixed-use'     => 7,
            default         => 8 // 'other' category
        };
    }
}
