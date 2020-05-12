<?php

namespace App\Models;

use App\User;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\LocationDetailUser
 *
 * @method static Builder|LocationDetailUser newModelQuery()
 * @method static Builder|LocationDetailUser newQuery()
 * @method static Builder|LocationDetailUser query()
 * @mixin Eloquent
 * @property-read LocationDetail $locationDetail
 * @property-read User $user
 */
class LocationDetailUser extends Model
{
    public function locationDetail(): BelongsTo
    {
        return $this->belongsTo(LocationDetail::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
