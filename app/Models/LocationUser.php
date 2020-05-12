<?php

namespace App\Models;

use App\User;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\LocationUser
 *
 * @property int $id
 * @property int $location_id
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Location $location
 * @property-read User $user
 * @method static Builder|LocationUser newModelQuery()
 * @method static Builder|LocationUser newQuery()
 * @method static Builder|LocationUser query()
 * @method static Builder|LocationUser whereCreatedAt($value)
 * @method static Builder|LocationUser whereId($value)
 * @method static Builder|LocationUser whereLocationId($value)
 * @method static Builder|LocationUser whereUpdatedAt($value)
 * @method static Builder|LocationUser whereUserId($value)
 * @mixin Eloquent
 */
class LocationUser extends Model
{
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
