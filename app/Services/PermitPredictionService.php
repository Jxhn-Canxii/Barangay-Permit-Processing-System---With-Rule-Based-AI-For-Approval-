<?php

namespace App\Services;

use Illuminate\Http\Request;
use Phpml\Classification\DecisionTree;
use Phpml\Dataset\CsvDataset;

class PermitPredictionService
{
    private $modelPath;
    private $logPath;

    public function __construct()
    {
        $this->modelPath = storage_path('app/prediction/model.serialize');
        $this->logPath = storage_path('app/prediction/logs.json');
    }

    private function logData(array $data)
    {
        $logEntries = file_exists($this->logPath) ? json_decode(file_get_contents($this->logPath), true) : [];
        $logEntries[] = $data;
        file_put_contents($this->logPath, json_encode($logEntries, JSON_PRETTY_PRINT));
    }

    public function trainModel()
    {
        $datasetPath = storage_path('app/prediction/zoning_permit_training_data.csv');
        
        $logData = [
            'timestamp' => now()->toDateTimeString(),
            'status' => 'Training started'
        ];
    
        if (!file_exists($datasetPath)) {
            $logData['error'] = 'Training dataset not found';
            $this->logData($logData);
            return response()->json(['message' => 'Training dataset not found. Check logs for details'], 500);
        }
    
        try {
            $dataset = new CsvDataset($datasetPath, 16, true);
            $classifier = new DecisionTree();
            $classifier->train($dataset->getSamples(), $dataset->getTargets());
            file_put_contents($this->modelPath, serialize($classifier));
    
            $logData['status'] = 'Training successful';
        } catch (\Exception $e) {
            $logData['error'] = 'Training failed: ' . $e->getMessage();
        }
    
        $this->logData($logData);
        return response()->json(['message' => 'Model trained. Check logs for details.']);
    }
    
    public function predict($data)
    {
        if (!file_exists($this->modelPath)) {
            return response()->json(['message' => 'Model not trained yet'], 500);
        }
    
        $classifier = unserialize(file_get_contents($this->modelPath));
    
        if (!$classifier instanceof DecisionTree) {
            return response()->json(['message' => 'Invalid model data'], 500);
        }
    
        $sample = array_values($data);
    
        try {
            $prediction = $classifier->predict([$sample])[0];
    
            $this->logData([
                'timestamp' => now()->toDateTimeString(),
                'input' => $sample,
                'prediction' => $prediction
            ]);
    
            return $prediction;
        } catch (\Exception $e) {
            $this->logData([
                'timestamp' => now()->toDateTimeString(),
                'error' => 'Prediction failed: ' . $e->getMessage()
            ]);
            return response()->json(['message' => 'Prediction failed', 'error' => $e->getMessage()], 500);
        }
    }
}