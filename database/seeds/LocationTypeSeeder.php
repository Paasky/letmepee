<?php

use App\Models\LocationType;
use Illuminate\Database\Seeder;

class LocationTypeSeeder extends Seeder
{
    public function run()
    {
        foreach ([
                     [
                         'id' => LocationType::ID_BAR,
                         'title' => 'Bar/Pub',
                         'description' => 'Inside a bar or pub, please ask for permission to use their toilet.',
                     ],
                     [
                         'id' => LocationType::ID_PUBLIC_BUILDING,
                         'title' => 'Public (building)',
                         'description' => 'Inside a public building, for example a mall or museum.',
                     ],
                     [
                         'id' => LocationType::ID_PUBLIC_INDOOR,
                         'title' => 'Public (indoor)',
                         'description' => 'Indoors public space, for example a train station.',
                     ],
                     [
                         'id' => LocationType::ID_PUBLIC_OUTDOOR,
                         'title' => 'Public (outdoor)',
                         'description' => 'Outdoors, for example in a park or sidewalk.',
                     ],
                     [
                         'id' => LocationType::ID_RESTAURANT,
                         'title' => 'Restaurant',
                         'description' => 'Inside a restaurant, please ask for permission to use their toilet',
                     ],
                 ] as $locationType) {
            LocationType::updateOrCreate(['id' => $locationType['id']], $locationType);
        }
    }
}