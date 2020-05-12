<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Models\Audit;

/**
 * App\Models\MapScan
 *
 * @property int $id
 * @property string $coords
 * @property float $lat
 * @property float $lng
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Audit[] $audits
 * @property-read int|null $audits_count
 * @method static Builder|MapScan newModelQuery()
 * @method static Builder|MapScan newQuery()
 * @method static Builder|MapScan query()
 * @method static Builder|MapScan whereCoords($value)
 * @method static Builder|MapScan whereCreatedAt($value)
 * @method static Builder|MapScan whereId($value)
 * @method static Builder|MapScan whereLat($value)
 * @method static Builder|MapScan whereLng($value)
 * @method static Builder|MapScan whereUpdatedAt($value)
 * @mixin Eloquent
 */
class MapScan extends LmpModel
{
    //
}
