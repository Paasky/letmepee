<?php

namespace App\Models;

use App\User;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Models\Audit;

/**
 * App\Models\Location
 *
 * @property int $id
 * @property string $coords
 * @property float $lat
 * @property float $lng
 * @property string $name
 * @property string $type
 * @property string $status
 * @property string $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Audit[] $audits
 * @property-read int|null $audits_count
 * @property-read Collection|User[] $creators
 * @property-read int|null $creators_count
 * @property-read Collection|LocationDetail[] $details
 * @property-read int|null $details_count
 * @property-read Collection|User[] $reviewers
 * @property-read int|null $reviewers_count
 * @property-read Collection|Review[] $reviews
 * @property-read int|null $reviews_count
 * @method static Builder|Location newModelQuery()
 * @method static Builder|Location newQuery()
 * @method static Builder|Location query()
 * @method static Builder|Location whereCoords($value)
 * @method static Builder|Location whereCreatedAt($value)
 * @method static Builder|Location whereDescription($value)
 * @method static Builder|Location whereId($value)
 * @method static Builder|Location whereLat($value)
 * @method static Builder|Location whereLng($value)
 * @method static Builder|Location whereName($value)
 * @method static Builder|Location whereStatus($value)
 * @method static Builder|Location whereType($value)
 * @method static Builder|Location whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Location extends LmpModel
{
    public function creators(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, LocationUser::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(LocationDetail::class);
    }

    public function reviewers(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, Review::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
