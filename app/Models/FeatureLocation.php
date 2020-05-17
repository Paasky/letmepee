<?php

namespace App\Models;

use App\Models\Common\LmpModel;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\FeatureLocation
 *
 * @property int $id
 * @property string $feature_id
 * @property int $location_id
 * @property int $user_id
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Approval[] $approvals
 * @property-read int|null $approvals_count
 * @property-read Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read int|null $audits_count
 * @property-read Feature $feature
 * @property-read Location $location
 * @property-read User $user
 * @method static Builder|FeatureLocation newModelQuery()
 * @method static Builder|FeatureLocation newQuery()
 * @method static Builder|FeatureLocation query()
 * @method static Builder|FeatureLocation whereCreatedAt($value)
 * @method static Builder|FeatureLocation whereDescription($value)
 * @method static Builder|FeatureLocation whereFeatureId($value)
 * @method static Builder|FeatureLocation whereId($value)
 * @method static Builder|FeatureLocation whereLocationId($value)
 * @method static Builder|FeatureLocation whereUpdatedAt($value)
 * @method static Builder|FeatureLocation whereUserId($value)
 * @mixin \Eloquent
 */
class FeatureLocation extends LmpModel
{
    protected $table = 'feature_location';

    protected $fillable = [
        'feature_id',
        'location_id',
        'user_id',
        'description',
    ];
    public function approvals(): MorphMany
    {
        return $this->morphMany(Approval::class, 'entity');
    }

    public function feature(): BelongsTo
    {
        return $this->belongsTo(Feature::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
