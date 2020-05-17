<?php

namespace App\Models;

use App\Models\Common\LmpModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Feature
 *
 * @property string $id
 * @property string $title
 * @property string|null $description
 * @property-read Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read int|null $audits_count
 * @property-read Collection|FeatureLocation[] $featureLocations
 * @property-read int|null $feature_locations_count
 * @property-read Collection|Location[] $locations
 * @property-read int|null $locations_count
 * @method static Builder|Feature newModelQuery()
 * @method static Builder|Feature newQuery()
 * @method static Builder|Feature query()
 * @method static Builder|Feature whereDescription($value)
 * @method static Builder|Feature whereId($value)
 * @method static Builder|Feature whereTitle($value)
 * @mixin \Eloquent
 */
class Feature extends LmpModel
{
    public const ID_SOAP = 'soap';
    public const IDS = [
        self::ID_SOAP,
    ];

    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'title',
        'description',
    ];

    public static function soap(): self
    {
        return static::getCached(static::ID_SOAP);
    }

    public function featureLocations(): HasMany
    {
        return $this->hasMany(FeatureLocation::class);
    }

    public function locations(): BelongsToMany
    {
        return $this->belongsToMany(Location::class);
    }
}
