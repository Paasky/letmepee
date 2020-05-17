<?php

namespace App\Models;

use App\Models\Common\LmpModel;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Approval
 *
 * @property int $id
 * @property string $entity_type
 * @property int $entity_id
 * @property int $user_id
 * @property bool $is_approved
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read int|null $audits_count
 * @property-read FeatureLocation|Location|Review|\Eloquent $entity
 * @property-read User $user
 * @method static Builder|Approval newModelQuery()
 * @method static Builder|Approval newQuery()
 * @method static Builder|Approval query()
 * @method static Builder|Approval whereCreatedAt($value)
 * @method static Builder|Approval whereEntityId($value)
 * @method static Builder|Approval whereEntityType($value)
 * @method static Builder|Approval whereId($value)
 * @method static Builder|Approval whereIsApproved($value)
 * @method static Builder|Approval whereUpdatedAt($value)
 * @method static Builder|Approval whereUserId($value)
 * @mixin \Eloquent
 */
class Approval extends LmpModel
{
    protected $fillable = [
        'entity_type',
        'entity_id',
        'user_id',
        'is_approved',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    public function entity(): MorphTo
    {
        return $this->morphTo('entity');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
