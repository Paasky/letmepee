<?php

namespace Tests;

use App\Models\Approval;
use App\Models\Feature;
use App\Models\FeatureLocation;
use App\Models\Location;
use App\Models\LocationType;
use App\Models\Review;
use App\User;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $autoSaveModels = false;

    /**
     * @param bool $isApproved
     * @param FeatureLocation|Location|Review $entity
     * @param User $user
     * @return Approval
     */
    protected function approval(bool $isApproved, $entity = null, User $user = null): Approval
    {
        if (!$entity) {
            $entity = $this->location();
        }
        if (!$user) {
            $user = $this->user();
        }
        $model = new Approval([
            'entity_type' => get_class($entity),
            'entity_id' => $entity->id,
            'user_id' => $user->id,
            'is_approved' => $isApproved,
        ]);

        if ($this->autoSaveModels) {
            $model->save();
        }

        return $model;
    }

    protected function coords(): Point
    {
        return new Point(
            random_int(51 * 10000, 52 * 10000) / 10000,
            random_int(-1 * 10000, 1 * 10000) / 10000,
        );
    }

    protected function featureLocation(Feature $feature = null, Location $location = null, User $user = null): FeatureLocation
    {
        if (!$feature) {
            $feature = Feature::soap();
        }
        if (!$location) {
            $location = $this->location();
        }
        if (!$user) {
            $user = $this->user();
        }

        $model = new FeatureLocation([
            'feature_id' => $feature->id,
            'location_id' => $location->id,
            'user_id' => $user->id,
            'description' => "Under the tree",
        ]);

        if ($this->autoSaveModels) {
            $model->save();
        }

        return $model;
    }

    protected function location(Point $coords = null, LocationType $locationType = null, User $user = null): Location
    {
        if (!$coords) {
            $coords = $this->coords();
        }
        if (!$locationType) {
            $locationType = LocationType::publicOutdoor();
        }
        if (!$user) {
            $user = $this->user();
        }
        $model = new Location([
            'location_type_id' => $locationType->id,
            'user_id' => $user->id,
            'title' => 'Wee pee',
            'description' => 'Gotta do wotcha gotta do',
            'status' => Location::STATUS_VERIFIED,
            'coords' => $coords,
            'lat' => $coords->getLat(),
            'lng' => $coords->getLng(),
        ]);

        if ($this->autoSaveModels) {
            $model->save();
        }

        return $model;
    }

    protected function review(Location $location = null, User $user = null, int $rating = 4): Review
    {
        if (!$location) {
            $location = $this->location();
        }

        if (!$user) {
            $user = $this->user();
        }

        $model = new Review([
            'location_id' => $location->id,
            'user_id' => $user->id,
            'title' => 'Cool spot',
            'description' => 'Yo dawg, pee like a dog',
            'rating' => $rating,
        ]);

        if ($this->autoSaveModels) {
            $model->save();
        }

        return $model;
    }

    protected function user(): User
    {
        $model = new User([
            'name' => 'Test User',
            'email' => 'test' . rand(1, 999999999) . '@letmepee.com',
            'password' => \Hash::make('password'),
        ]);

        if ($this->autoSaveModels) {
            $model->save();
        }

        return $model;
    }
}
