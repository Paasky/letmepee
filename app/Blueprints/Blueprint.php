<?php

namespace App\Blueprints;

use app\Exceptions\InvalidArgumentsException;
use App\Models\Common\LmpModel;

interface Blueprint
{
    public static function fromModel(LmpModel $model): self;

    /**
     * @param bool $verify
     * @return bool
     * @throws InvalidArgumentsException
     */
    public function isValid(bool $verify = false): bool;

    /**
     * @param bool $validate
     * @return array
     * @throws InvalidArgumentsException
     */
    public function getModelParams(bool $validate = true): array;

    /**
     * @param bool $validate
     * @return array
     * @throws InvalidArgumentsException
     */
    public function getSearchParams(bool $validate = true): array;
}
