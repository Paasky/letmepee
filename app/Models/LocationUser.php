<?php

namespace App\Models;

use App\User;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\LocationUser
 *
 * @method static Builder|LocationUser newModelQuery()
 * @method static Builder|LocationUser newQuery()
 * @method static Builder|LocationUser query()
 * @mixin Eloquent
 * @property-read Location $location
 * @property-read User $user
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
