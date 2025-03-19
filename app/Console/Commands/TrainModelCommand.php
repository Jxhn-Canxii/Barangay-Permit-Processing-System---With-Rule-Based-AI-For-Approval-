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
        $trainingData = collect(DB::table('zoning_permits')
            ->whereIn('status_id', [2, 3])
            ->get())
            ->map(function ($permit) {
                return [
                    'inputs' => [
                        $this->normalizeZip($permit->zip),
                        $this->encodeLandRight($permit->right_over_land),
                        (float)$permit->lot_area,
                        $this->encodeZoneType($permit->zoning_district),
                        $this->encodeProposedUse($permit->proposed_use),
                        (int)$permit->existing_structures,
                        (int)$permit->setback_compliance
                    ],
                    'labels' => $permit->status_id === 2 ? 'approved' : 'rejected'
                ];
            });

        $formatted = [
            'inputs' => $trainingData->pluck('inputs')->toArray(),
            'labels' => $trainingData->pluck('labels')->toArray()
        ];

        (new PermitPredictionService())->trainModel($formatted);
        // $this->info(json_encode($formatted, JSON_PRETTY_PRINT));

        $this->info('Model trained and saved successfully');
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
