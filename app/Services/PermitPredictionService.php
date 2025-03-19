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
    protected $modelFile = 'storage/ml/trained_permit_model.rbx';
    protected $scalerFile = 'storage/ml/scaler.rbx';

    public function __construct()
    {
        $this->scaler = new ZScaleStandardizer();

        if (file_exists($this->modelFile)) {
            $this->loadModel();
        }
    }

    private function loadModel()
    {
        if (!file_exists($this->modelFile)) {
            throw new Exception("Model file not found. Train the model first.");
        }

        $serializer = new Native();
        $this->classifier = $serializer->deserialize(file_get_contents($this->modelFile));

        if (!file_exists($this->scalerFile)) {
            throw new Exception("Scaler file not found. Train the model first.");
        }
        
        $this->scaler = unserialize(file_get_contents($this->scalerFile));
    }

    public function trainModel(array $data)
    {
        if (!isset($data['inputs']) || !isset($data['labels'])) {
            throw new Exception("Invalid training data format");
        }

        $dataset = new Labeled($data['inputs'], $data['labels']);

        $this->scaler->fit($dataset);
        $dataset->apply($this->scaler);

        $this->classifier = new RandomForest(new ClassificationTree(10), 100); // Added depth limit

        $this->classifier->train($dataset);

        // Save model using Native serializer
        $serializer = new Native();
        file_put_contents($this->modelFile, $serializer->serialize($this->classifier));
        
        // Save scaler using native PHP serialization
        file_put_contents($this->scalerFile, serialize($this->scaler));
    }

    public function predict(array $data)
    {
        if (!$this->classifier) {
            throw new Exception("Model not trained or loaded");
        }

        if (empty($data)) {
            throw new Exception("Invalid input data");
        }

        $dataset = new Unlabeled([$data]);
        $dataset->apply($this->scaler);

        return $this->classifier->predict($dataset)[0];
    }
}