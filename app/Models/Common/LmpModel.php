<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;
use OwenIt\Auditing\Auditable;

abstract class LmpModel extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use Auditable;

    /** @var static[] */
    protected static $cache = [];

    public static function cleanClass(): string
    {
        return Arr::last(explode('\\', static::class));
    }

    public static function cacheAll(): void
    {
        foreach (static::all() as $model) {
            $model->cache();
        }
    }

    /**
     * @return static[]
     */
    public static function getCache(): array
    {
        return static::$cache;
    }

    /**
     * @param int|int[]|string|string[] $idOrIds
     * @param bool $orFail
     * @param bool $findIfNotPresent
     * @return static|static[]|null
     */
    public static function getCached($idOrIds, bool $orFail = false, bool $findIfNotPresent = true)
    {
        $models = [];
        $errors = [];
        $ids = is_array($idOrIds) ? $idOrIds : [$idOrIds];

        foreach ($ids as $id) {
            $model = static::$cache[$id] ?? null;

            if (!$model && $findIfNotPresent) {
                static::$cache[$id] = $model = static::find($id) ?: null;
            }

            if ($model) {
                $models[$model->getKey()] = $model;
            } elseif ($orFail) {
                $errors[] = static::cleanClass() . " [$id] not found";
            }
        }

        if ($errors) {
            throw new ModelNotFoundException(implode(',', $errors));
        }

        return is_array($idOrIds) ? $models : Arr::first($models);
    }

    /**
     * @param int|int[]|string|string[]|null $idOrIds
     */
    public static function refreshCache($idOrIds = null): void
    {
        if ($idOrIds) {
            $ids = is_array($idOrIds) ? $idOrIds : [$idOrIds];
        } else {
            $ids = array_keys(static::$cache);
        }
        foreach ($ids as $id) {
            static::$cache[$id] = null;
        }
        static::getCached($idOrIds);
    }

    /**
     * @return static
     */
    public function cache(): self
    {
        static::$cache[$this->getKey()] = $this;
        return $this;
    }
}