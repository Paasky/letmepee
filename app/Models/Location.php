<?php

namespace App\Models;

use App\Models\Common\LmpModel;
use App\User;
use Eloquent;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Models\Audit;

/**
 * App\Models\Location
 *
 * @property int $id
 * @property string $location_type_id
 * @property int|null $user_id
 * @property string $title
 * @property string|null $description
 * @property string $status
 * @property Point $coords
 * @property float $lat
 * @property float $lng
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Approval[] $approvals
 * @property-read int|null $approvals_count
 * @property-read Collection|Audit[] $audits
 * @property-read int|null $audits_count
 * @property-read Collection|FeatureLocation[] $featureLocations
 * @property-read int|null $feature_locations_count
 * @property-read Collection|Feature[] $features
 * @property-read int|null $features_count
 * @property-read Collection|User[] $reviewers
 * @property-read int|null $reviewers_count
 * @property-read Collection|Review[] $reviews
 * @property-read int|null $reviews_count
 * @property-read LocationType $type
 * @property-read User|null $user
 * @method static Builder|Location comparison($geometryColumn, $geometry, $relationship)
 * @method static Builder|Location contains($geometryColumn, $geometry)
 * @method static Builder|Location crosses($geometryColumn, $geometry)
 * @method static Builder|Location disjoint($geometryColumn, $geometry)
 * @method static Builder|Location distance($geometryColumn, $geometry, $distance)
 * @method static Builder|Location distanceExcludingSelf($geometryColumn, $geometry, $distance)
 * @method static Builder|Location distanceSphere($geometryColumn, $geometry, $distance)
 * @method static Builder|Location distanceSphereExcludingSelf($geometryColumn, $geometry, $distance)
 * @method static Builder|Location distanceSphereValue($geometryColumn, $geometry)
 * @method static Builder|Location distanceValue($geometryColumn, $geometry)
 * @method static Builder|Location doesTouch($geometryColumn, $geometry)
 * @method static Builder|Location equals($geometryColumn, $geometry)
 * @method static Builder|Location intersects($geometryColumn, $geometry)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|Location newModelQuery()
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|Location newQuery()
 * @method static Builder|Location orderByDistance($geometryColumn, $geometry, $direction = 'asc')
 * @method static Builder|Location orderByDistanceSphere($geometryColumn, $geometry, $direction = 'asc')
 * @method static Builder|Location orderBySpatial($geometryColumn, $geometry, $orderFunction, $direction = 'asc')
 * @method static Builder|Location overlaps($geometryColumn, $geometry)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|Location query()
 * @method static Builder|Location whereCoords($value)
 * @method static Builder|Location whereCreatedAt($value)
 * @method static Builder|Location whereDescription($value)
 * @method static Builder|Location whereId($value)
 * @method static Builder|Location whereLat($value)
 * @method static Builder|Location whereLng($value)
 * @method static Builder|Location whereLocationTypeId($value)
 * @method static Builder|Location whereStatus($value)
 * @method static Builder|Location whereTitle($value)
 * @method static Builder|Location whereUpdatedAt($value)
 * @method static Builder|Location whereUserId($value)
 * @method static Builder|Location within($geometryColumn, $polygon)
 * @mixin Eloquent
 */
class Location extends LmpModel
{
    use SpatialTrait;

    public const TYPE_BAR = 'bar';
    public const TYPE_BUILDING = 'building';
    public const TYPE_PUBLIC = 'public';
    public const TYPE_URINAL = 'urinal';
    public const TYPES = [
        self::TYPE_BAR,
        self::TYPE_BUILDING,
        self::TYPE_PUBLIC,
        self::TYPE_URINAL,
    ];

    public const STATUS_UNVERIFIED = 'unverified';
    public const STATUS_VERIFIED = 'verified';
    public const STATUSES = [
        self::STATUS_UNVERIFIED,
        self::STATUS_VERIFIED,
    ];

    protected $spatialFields = [
        'coords'
    ];

    protected $fillable = [
        'location_type_id',
        'user_id',
        'title',
        'description',
        'status',
        'coords',
        'lat',
        'lng',
    ];

    public function approvals(): MorphMany
    {
        return $this->morphMany(Approval::class, 'entity');
    }

    public function featureLocations(): HasMany
    {
        return $this->hasMany(FeatureLocation::class);
    }

    public function features(): BelongsToMany
    {
        return $this->belongsToMany(Feature::class);
    }

    public function reviewers(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, Review::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(LocationType::class, 'location_type_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
