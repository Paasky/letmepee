<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;

abstract class LmpModel extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use Auditable;
}