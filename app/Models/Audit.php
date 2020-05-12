<?php

namespace App\Models;

use App\User;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Audit
 *
 * @property int $id
 * @property string|null $user_type
 * @property int|null $user_id
 * @property string $event
 * @property string $auditable_type
 * @property int $auditable_id
 * @property array|null $old_values
 * @property array|null $new_values
 * @property string|null $url
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property string|null $tags
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Model|LmpModel|Eloquent $auditable
 * @property-read User|Eloquent $user
 * @method static Builder|Audit newModelQuery()
 * @method static Builder|Audit newQuery()
 * @method static Builder|Audit query()
 * @method static Builder|Audit whereAuditableId($value)
 * @method static Builder|Audit whereAuditableType($value)
 * @method static Builder|Audit whereCreatedAt($value)
 * @method static Builder|Audit whereEvent($value)
 * @method static Builder|Audit whereId($value)
 * @method static Builder|Audit whereIpAddress($value)
 * @method static Builder|Audit whereNewValues($value)
 * @method static Builder|Audit whereOldValues($value)
 * @method static Builder|Audit whereTags($value)
 * @method static Builder|Audit whereUpdatedAt($value)
 * @method static Builder|Audit whereUrl($value)
 * @method static Builder|Audit whereUserAgent($value)
 * @method static Builder|Audit whereUserId($value)
 * @method static Builder|Audit whereUserType($value)
 * @mixin Eloquent
 */
class Audit extends \OwenIt\Auditing\Models\Audit
{

}
