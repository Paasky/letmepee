<?php

namespace App\Models;

use App\Models\Common\LmpModel;
use App\User;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Models\Audit;

/**
 * App\Models\Review
 *
 * @property int $id
 * @property int $location_id
 * @property int $user_id
 * @property string $title
 * @property string|null $description
 * @property int $rating
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Approval[] $approvals
 * @property-read int|null $approvals_count
 * @property-read Collection|Audit[] $audits
 * @property-read int|null $audits_count
 * @property-read Location $location
 * @property-read User $user
 * @method static Builder|Review newModelQuery()
 * @method static Builder|Review newQuery()
 * @method static Builder|Review query()
 * @method static Builder|Review whereCreatedAt($value)
 * @method static Builder|Review whereDescription($value)
 * @method static Builder|Review whereId($value)
 * @method static Builder|Review whereLocationId($value)
 * @method static Builder|Review whereRating($value)
 * @method static Builder|Review whereTitle($value)
 * @method static Builder|Review whereUpdatedAt($value)
 * @method static Builder|Review whereUserId($value)
 * @mixin Eloquent
 */
class Review extends LmpModel
{
    protected $fillable = [
        'location_id',
        'user_id',
        'title',
        'description',
        'rating',
    ];

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function approvals(): MorphMany
    {
        return $this->morphMany(Approval::class, 'entity');
    }
}
