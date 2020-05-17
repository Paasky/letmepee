<?php

namespace App;

use App\Models\Approval;
use App\Models\FeatureLocation;
use App\Models\Location;
use App\Models\Review;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Models\Audit;

/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Approval[] $approvals
 * @property-read int|null $approvals_count
 * @property-read Collection|Audit[] $audits
 * @property-read int|null $audits_count
 * @property-read Collection|FeatureLocation[] $featureLocations
 * @property-read int|null $feature_locations_count
 * @property-read Collection|Location[] $locations
 * @property-read int|null $locations_count
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection|Review[] $reviews
 * @property-read int|null $reviews_count
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @mixin Eloquent
 */
class User extends Authenticatable implements \OwenIt\Auditing\Contracts\Auditable
{
    use Auditable;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function approvals(): HasMany
    {
        return $this->hasMany(Approval::class);
    }

    public function featureLocations(): HasMany
    {
        return $this->hasMany(FeatureLocation::class);
    }

    public function locations(): HasMany
    {
        return $this->hasMany(Location::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
