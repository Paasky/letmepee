<?php

use App\Blueprints\LocationBlueprint;
use App\Models\Common\HasCoordinates;
use App\Models\FeatureLocation;
use App\Models\Location;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Support\Collection;

class LocationManager
{
    public static function create(LocationBlueprint $blueprint): Location
    {
        $location = Location::create($blueprint->getModelParams());

        foreach ($blueprint->getFeatureLocationsParams($location, false) as $featureLocationParams) {
            FeatureLocation::create($featureLocationParams);
        }

        return $location;
    }

    /**
     * @param Location|LocationBlueprint $locationOrBlueprint
     * @param int $range
     * @return Collection
     */
    public function findSimilar($locationOrBlueprint, int $range = 50): Collection
    {
        if ($locationOrBlueprint instanceof Location) {
            $center = $locationOrBlueprint->coords;
            $typeId = $locationOrBlueprint->location_type_id;
        } else {
            $center = $locationOrBlueprint->getCoords();
            $typeId = $locationOrBlueprint->getType()->id;
        }

        return Location
            ::inRange($center, $range)
            ->where('location_type_id', $typeId)
            ->get();
    }

    /**
     * @param HasCoordinates|Point $from
     * @param HasCoordinates|Point $to
     * @return int
     */
    public static function getDistanceInMeters($from, $to): int
    {
        if (isset($from->coords)) {
            $from = $from->coords;
        }
        if (isset($to->coords)) {
            $to = $to->coords;
        }
        $lat1 = $from->getLat();
        $lat2 = $to->getLat();
        $lng1 = $from->getLng();
        $lng2 = $to->getLng();

        if (($lat1 == $lat2) && ($lng1 == $lng2)) {
            return 0;
        }
        else {
            $theta = $lng1 - $lng2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            return round($dist * 111189.57696);
        }
    }
}