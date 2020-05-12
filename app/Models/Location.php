<?php

namespace App\Models;

use App\User;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use OwenIt\Auditing\Models\Audit;

/**
 * App\Models\Location
 *
 * @property-read Collection|Audit[] $audits
 * @property-read int|null $audits_count
 * @method static Builder|Location newModelQuery()
 * @method static Builder|Location newQuery()
 * @method static Builder|Location query()
 * @mixin Eloquent
 * @property-read Collection|User[] $creators
 * @property-read int|null $creators_count
 * @property-read Collection|LocationDetail[] $details
 * @property-read int|null $details_count
 * @property-read Collection|User[] $reviewers
 * @property-read int|null $reviewers_count
 * @property-read Collection|Review[] $reviews
 * @property-read int|null $reviews_count
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
