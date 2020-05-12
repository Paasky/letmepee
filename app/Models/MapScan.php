<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use OwenIt\Auditing\Models\Audit;

/**
 * App\Models\MapScan
 *
 * @property-read Collection|Audit[] $audits
 * @property-read int|null $audits_count
 * @method static Builder|MapScan newModelQuery()
 * @method static Builder|MapScan newQuery()
 * @method static Builder|MapScan query()
 * @mixin Eloquent
 */
class MapScan extends LmpModel
{
    //
}
