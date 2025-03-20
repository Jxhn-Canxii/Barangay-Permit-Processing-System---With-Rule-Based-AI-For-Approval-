<?php

namespace App\Services;

use Illuminate\Http\Request;
use Phpml\Classification\DecisionTree;
use Phpml\Dataset\CsvDataset;

class PermitPredictionService
{
    public function trainModel()
    {
        $dataset = new CsvDataset(storage_path('app/prediction/data.csv'), 1, true);

        $classifier = new DecisionTree();
        $classifier->train($dataset->getSamples(), $dataset->getTargets());

        // JSON
        file_put_contents(storage_path('app/prediction/model.json'), json_encode($classifier));
        
        return response()->json(['message' => 'Model trained and saved']);
    }

    public function predict($data)
    {
        // $data = $request->all();
        $sample = array_values($data); //array format

        // Load the trained model (deserialize)
        $classifier = json_decode(file_get_contents(storage_path('app/prediction/model.json')), true);
        
        $prediction = $classifier->predict($sample);

        return response()->json(['prediction' => $prediction]);
    }
}