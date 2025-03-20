<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Phpml\Classification\DecisionTree;
use Phpml\Dataset\CsvDataset;

class MachineLearningController extends Controller
{
    public function trainModel()
    {
        $dataset = new CsvDataset(storage_path('app/data.csv'), 1, true);

        $classifier = new DecisionTree();
        $classifier->train($dataset->getSamples(), $dataset->getTargets());

        // JSON
        file_put_contents(storage_path('app/model.json'), json_encode($classifier));
        
        return response()->json(['message' => 'Model trained and saved']);
    }

    public function predict(Request $request)
    {
        $data = $request->all();
        $sample = array_values($data); //array format

        // Load the trained model (deserialize)
        $classifier = json_decode(file_get_contents(storage_path('app/model.json')), true);
        
        $prediction = $classifier->predict($sample);

        return response()->json(['prediction' => $prediction]);
    }
}