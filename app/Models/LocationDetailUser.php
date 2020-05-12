<?php

namespace App\Models;

use App\User;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\LocationDetailUser
 *
 * @property int $id
 * @property int $location_detail_id
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read LocationDetail $locationDetail
 * @property-read User $user
 * @method static Builder|LocationDetailUser newModelQuery()
 * @method static Builder|LocationDetailUser newQuery()
 * @method static Builder|LocationDetailUser query()
 * @method static Builder|LocationDetailUser whereCreatedAt($value)
 * @method static Builder|LocationDetailUser whereId($value)
 * @method static Builder|LocationDetailUser whereLocationDetailId($value)
 * @method static Builder|LocationDetailUser whereUpdatedAt($value)
 * @method static Builder|LocationDetailUser whereUserId($value)
 * @mixin Eloquent
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
