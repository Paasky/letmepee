<?php

namespace Tests\Unit;

use App\Models\Approval;
use App\Models\Feature;
use App\Models\FeatureLocation;
use App\Models\Location;
use App\Models\LocationType;
use App\Models\Review;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ModelsTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->autoSaveModels = true;
    }

    public function testApproval()
    {
        // 1) Test fillables
        $modelParams = [
            'entity_type' => 'entity type',
            'entity_id' => 123,
            'user_id' => 234,
            'is_approved' => false,
        ];
        $this::assertEquals($modelParams, (new Approval($modelParams))->toArray());

        // 2) Test relations
        $entity = $this->location();
        $user = $this->user();
        $approval = $this->approval(true, $entity, $user);

        $this::assertEquals($entity->id, $approval->entity->id);
        $this::assertEquals($user->id, $approval->user->id);
    }

    public function testFeature()
    {
        // 1) Test fillables
        $modelParams = [
            'id' => 'bcd234',
            'title' => 'title title',
            'description' => 'such description',
        ];
        $this::assertEquals($modelParams, (new Feature($modelParams))->toArray());

        // 2) Test relations
        $feature = Feature::soap();
        $location = $this->location();
        $featureLocation = $this->featureLocation($feature, $location);

        $this::assertEquals($featureLocation->id, $feature->featureLocations[0]->id);
        $this::assertEquals($location->id, $feature->locations[0]->id);
    }

    public function testFeatureLocation()
    {
        // 1) Test fillables
        $modelParams = [
            'feature_id' => 45,
            'location_id' => 56,
            'user_id' => 67,
            'description' => 'descriptive!',
        ];
        $this::assertEquals($modelParams, (new FeatureLocation($modelParams))->toArray());

        // 2) Test relations
        $feature = Feature::soap();
        $location = $this->location();
        $user = $this->user();
        $featureLocation = $this->featureLocation($feature, $location, $user);

        $this::assertEquals($feature->id, $featureLocation->feature->id);
        $this::assertEquals($location->id, $featureLocation->location->id);
        $this::assertEquals($user->id, $featureLocation->user->id);
    }

    public function testLocation()
    {
        // 1) Test fillables
        $coords = $this->coords();
        $modelParams = [
            'location_type_id' => 'an-id',
            'user_id' => 34,
            'title' => 'cool location',
            'description' => 'descriptive',
            'status' => Location::STATUS_VERIFIED,
            'coords' => $coords,
        ];
        $this::assertEquals(
            $modelParams + ['lat' => $coords->getLat(), 'lng' => $coords->getLng()],
            (new Location($modelParams))->toArray()
        );

        // 2) Test relations & special columns
        $locationType = LocationType::bar();
        $user = $this->user();
        $location = $this->location($coords, $locationType, $user);
        $feature = Feature::soap();
        $featureLocation = $this->featureLocation($feature, $location);
        $user2 = $this->user();
        $review = $this->review($location, $user2);

        $this::assertEquals($coords->toJson(), $location->coords->toJson());
        $this::assertEquals($locationType->id, $location->type->id);
        $this::assertEquals($user->id, $location->user->id);
        $this::assertEquals($featureLocation->id, $location->featureLocations[0]->id);
        $this::assertEquals($feature->id, $location->features[0]->id);
        $this::assertEquals($review->id, $location->reviews[0]->id);
        $this::assertEquals($user2->id, $location->reviewers[0]->id);

        // 3) Assert throws on lat-lng
        $this::assertThrows(
            function() {
                new Location(['lat' => 12.34]);
            },
            new \BadFunctionCallException("lat-attribute is read-only. Set coords to update lat-lng values")
        );
        $this::assertThrows(
            function() {
                $location = new Location();
                $location->lng = 12.34;
            },
            new \BadFunctionCallException("lng-attribute is read-only. Set coords to update lat-lng values")
        );
    }

    public function testLocationType()
    {
        // 1) Test fillables
        $modelParams = [
            'id' => 'asd321',
            'title' => 'another title',
            'description' => 'and a description',
        ];
        $this::assertEquals($modelParams, (new LocationType($modelParams))->toArray());

        // 2) Test relations
        $locationType = LocationType::publicOutdoor();
        $location = $this->location(null, $locationType);
        $this::assertEquals($location->id, $locationType->locations[0]->id);
    }

    public function testReview()
    {
        // 1) Test fillables
        $modelParams = [
            'location_id' => 12,
            'user_id' => 23,
            'title' => 'a title',
            'description' => 'something',
            'rating' => 2,
        ];
        $this::assertEquals($modelParams, (new Review($modelParams))->toArray());

        // 2) Test relations
        $location = $this->location();
        $user = $this->user();
        $review = $this->review($location, $user);
        $this::assertEquals($location->id, $review->location->id);
        $this::assertEquals($user->id, $review->user->id);
    }

    public function testUser()
    {
        // 1) Test fillables
        $modelParams = [
            'name' => 'a name',
            'email' => 'abc@123',
            'password' => 'abc123',
        ];
        $this::assertEquals($modelParams, (new User($modelParams))->makeVisible('password')->toArray());

        // 2) Test relations
        $user = $this->user();
        $approval = $this->approval(true, null, $user);
        $featureLocation = $this->featureLocation(null, null, $user);
        $location = $this->location(null, null, $user);
        $review = $this->review(null, $user);

        $this::assertEquals($approval->id, $user->approvals[0]->id);
        $this::assertEquals($featureLocation->id, $user->featureLocations[0]->id);
        $this::assertEquals($location->id, $user->locations[0]->id);
        $this::assertEquals($review->id, $user->reviews[0]->id);
    }
}
