<?php

namespace App\Services;

use Rubix\ML\Classifiers\RandomForest;
use Rubix\ML\Classifiers\ClassificationTree;
use Rubix\ML\Transformers\ZScaleStandardizer;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Datasets\Unlabeled;
use Rubix\ML\Serializers\Native;
use Exception;

class PermitPredictionService
{
    protected $classifier;
    protected $scaler;
    protected $modelFile;
    protected $scalerFile;

    public function __construct()
    {
        $this->modelFile = base_path('storage/ml/trained_permit_model.rbx');
        $this->scalerFile = base_path('storage/ml/scaler.rbx');
        
        $this->scaler = new ZScaleStandardizer();

        $this->ensureStorageDirectoryExists();
        
        if (file_exists($this->modelFile) && file_exists($this->scalerFile)) {
            $this->loadModel();
        }
    }

    private function ensureStorageDirectoryExists()
    {
        $dir = dirname($this->modelFile);
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }
    }
    
    private function loadModel()
    {
        try {
            // Check if model file exists
            if (!file_exists($this->modelFile)) {
                throw new Exception("Model file not found at: {$this->modelFile}");
            }
    
            // Deserialize the model
            $serializer = new Native();
            $modelData = file_get_contents($this->modelFile);
    
            if (!$modelData) {
                throw new Exception("Failed to read model file at: {$this->modelFile}");
            }
    
            $this->classifier = $serializer->deserialize($modelData);
    
            // Check if scaler file exists
            if (!file_exists($this->scalerFile)) {
                throw new Exception("Scaler file not found at: {$this->scalerFile}");
            }
    
            // Deserialize the scaler
            $scalerData = file_get_contents($this->scalerFile);
    
            if (!$scalerData) {
                throw new Exception("Failed to read scaler file at: {$this->scalerFile}");
            }
    
            $this->scaler = unserialize($scalerData);
        } catch (Exception $e) {
            throw new Exception("Error loading model: " . $e->getMessage());
        }
    }
    

    public function trainModel(array $data)
    {
        if (!isset($data['inputs']) || !isset($data['labels'])) {
            throw new Exception("Training data must contain 'inputs' and 'labels' keys");
        }

        $dataset = new Labeled($data['inputs'], $data['labels']);

        // Fit and apply scaler
        $this->scaler->fit($dataset);
        $dataset->apply($this->scaler);

        // Initialize and train classifier
        $this->classifier = new RandomForest(new ClassificationTree(10), 100);
        $this->classifier->train($dataset);

        // Save model and scaler
        $serializer = new Native();
        file_put_contents($this->modelFile, $serializer->serialize($this->classifier));
        file_put_contents($this->scalerFile, serialize($this->scaler));
    }

    public function predict(array $data)
    {
        if (!$this->classifier) {
            throw new Exception("Model not loaded. Check if files exist at: " . dirname($this->modelFile));
        }

        // Convert all values to floats
        $sample = array_map('floatval', $data);
        
        // Create unlabeled dataset
        $dataset = new Unlabeled([$sample]);
        $dataset->apply($this->scaler);

        return $this->classifier->predict($dataset)[0];
    }
}