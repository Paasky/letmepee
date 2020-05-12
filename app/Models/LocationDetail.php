<?php

namespace App\Models;

use App\User;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use OwenIt\Auditing\Models\Audit;

/**
 * App\Models\LocationDetails
 *
 * @property-read Collection|Audit[] $audits
 * @property-read int|null $audits_count
 * @method static Builder|LocationDetail newModelQuery()
 * @method static Builder|LocationDetail newQuery()
 * @method static Builder|LocationDetail query()
 * @mixin Eloquent
 * @property-read Collection|User[] $creators
 * @property-read int|null $creators_count
 * @property-read Location $location
 */
class LocationDetail extends LmpModel
{
    public function creators(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, LocationDetailUser::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
}
