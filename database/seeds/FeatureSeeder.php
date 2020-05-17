<?php

use App\Models\Feature;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    public function run()
    {
        foreach ([
            [
                'id' => Feature::ID_SOAP,
                'title' => 'Soap',
                'description' => 'You can wash your hands with soap.',
            ],
        ] as $feature) {
            Feature::updateOrCreate(['id' => $feature['id']], $feature);
        }
    }
}