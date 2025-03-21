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
        // Define model and log file paths inside storage
        $this->modelPath = storage_path('app/prediction/model.serialize');
        $this->logPath = storage_path('app/prediction/logs.json');
    }

    // Function to log training and prediction details to a JSON log file
    private function logData(array $data)
    {
        $logEntries = file_exists($this->logPath) ? json_decode(file_get_contents($this->logPath), true) : [];
        $logEntries[] = $data;
        file_put_contents($this->logPath, json_encode($logEntries, JSON_PRETTY_PRINT));
    }

    // Function to train the model
    public function trainModel()
    {
        $datasetPath = storage_path('app/prediction/zoning_permit_training_data.csv');
        $logData = [
            'timestamp' => now()->toDateTimeString(),
            'status' => 'Training started'
        ];
    
        // Check if the dataset file exists
        if (!file_exists($datasetPath)) {
            $logData['error'] = 'Training dataset not found';
            $this->logData($logData);
            return response()->json(['message' => 'Training dataset not found. Check logs for details'], 500);
        }
    
        try {
            // Load the training dataset
            $dataset = new CsvDataset($datasetPath, 16, true);
    
            // Create a new classifier or load the existing model
            $classifier = new DecisionTree();
    
            // Check if a previous model exists and train accordingly
            if (file_exists($this->modelPath)) {
                // Optionally load and continue training (this part is for fine-tuning)
                $classifier = unserialize(file_get_contents($this->modelPath)); 
            } else {
                // If no model exists, train from scratch
                $classifier->train($dataset->getSamples(), $dataset->getTargets());
            }
    
            // Save the trained model (either new or retrained model)
            file_put_contents($this->modelPath, serialize($classifier));
    
            // Log the success and details
            $logData['status'] = 'Training successful';
            $logData['dataset'] = $datasetPath;
            $logData['samples_count'] = count($dataset->getSamples());
            $logData['features_count'] = count($dataset->getSamples()[0]); // Assuming the first sample defines the number of features
    
        } catch (\Exception $e) {
            $logData['error'] = 'Training failed: ' . $e->getMessage();
        }
    
        // Log the status and training details
        $this->logData($logData);
    
        // Return the success response with detailed information
        return response()->json([
            'message' => 'Model trained successfully.',
            'status' => 'Success',
            'training_details' => [
                'dataset' => $datasetPath,
                'samples_count' => count($dataset->getSamples()),
                'features_count' => count($dataset->getSamples()[0]),
                'model_path' => $this->modelPath,
            ]
        ]);
    }    
    
    // Function to make predictions using the trained model
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
