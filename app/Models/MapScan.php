<?php

namespace App\Models;

use App\Models\Common\LmpModel;
use Eloquent;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Models\Audit;

/**
 * App\Models\MapScan
 *
 * @property int $id
 * @property Point $coords
 * @property float $lat
 * @property float $lng
 * @property int $range
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
 * @method static Builder|MapScan whereRange($value)
 * @method static Builder|MapScan whereUpdatedAt($value)
 * @mixin Eloquent
 */
class MapScan extends LmpModel
{
    //
}
