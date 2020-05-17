<?php

use App\Blueprints\LocationBlueprint;
use App\Models\Location;

class LocationManager
{
    public static function updateOrCreate(LocationBlueprint $blueprint): Location
    {
        return Location::updateOrCreate(
            $blueprint->getSearchParams(),
            $blueprint->getModelParams()
        );
    }
}