<?php

namespace App\Models;

use App\User;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Models\Audit;

/**
 * App\Models\LocationDetail
 *
 * @property int $id
 * @property int $location_id
 * @property string $type
 * @property string $status
 * @property string $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Audit[] $audits
 * @property-read int|null $audits_count
 * @property-read Collection|User[] $creators
 * @property-read int|null $creators_count
 * @property-read Location $location
 * @method static Builder|LocationDetail newModelQuery()
 * @method static Builder|LocationDetail newQuery()
 * @method static Builder|LocationDetail query()
 * @method static Builder|LocationDetail whereCreatedAt($value)
 * @method static Builder|LocationDetail whereDescription($value)
 * @method static Builder|LocationDetail whereId($value)
 * @method static Builder|LocationDetail whereLocationId($value)
 * @method static Builder|LocationDetail whereStatus($value)
 * @method static Builder|LocationDetail whereType($value)
 * @method static Builder|LocationDetail whereUpdatedAt($value)
 * @mixin Eloquent
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
