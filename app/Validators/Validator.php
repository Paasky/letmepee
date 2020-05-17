<?php

namespace app\Validators;

interface Validator
{
    /**
     * @param $value
     * @param bool $verify
     * @return bool
     * @throws \InvalidArgumentException
     */
    public static function isValid($value, bool $verify = false): bool;
}