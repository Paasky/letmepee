<?php

namespace App\Models;

use App\Models\Common\LmpModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\LocationType
 *
 * @property string $id
 * @property string $title
 * @property string|null $description
 * @property-read Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read int|null $audits_count
 * @property-read Collection|Location[] $locations
 * @property-read int|null $locations_count
 * @method static Builder|LocationType newModelQuery()
 * @method static Builder|LocationType newQuery()
 * @method static Builder|LocationType query()
 * @method static Builder|LocationType whereDescription($value)
 * @method static Builder|LocationType whereId($value)
 * @method static Builder|LocationType whereTitle($value)
 * @mixin \Eloquent
 */
class LocationType extends LmpModel
{
    public const ID_BAR = 'bar';
    public const ID_PUBLIC_BUILDING = 'public-building';
    public const ID_PUBLIC_INDOOR = 'public-indoor';
    public const ID_PUBLIC_OUTDOOR = 'public-outdoor';
    public const ID_RESTAURANT = 'restaurant';
    public const IDS = [
        self::ID_BAR,
        self::ID_PUBLIC_BUILDING,
        self::ID_PUBLIC_INDOOR,
        self::ID_PUBLIC_OUTDOOR,
        self::ID_RESTAURANT,
    ];

    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'title',
        'description',
    ];

    public static function bar(): self
    {
        return static::getCached(static::ID_BAR);
    }

    public static function publicBuilding(): self
    {
        return static::getCached(static::ID_PUBLIC_BUILDING);
    }

    public static function publicIndoor(): self
    {
        return static::getCached(static::ID_PUBLIC_INDOOR);
    }

    public static function publicOutdoor(): self
    {
        return static::getCached(static::ID_PUBLIC_OUTDOOR);
    }

    public static function restaurant(): self
    {
        return static::getCached(static::ID_RESTAURANT);
    }

    public function locations(): HasMany
    {
        return $this->hasMany(Location::class);
    }
}
