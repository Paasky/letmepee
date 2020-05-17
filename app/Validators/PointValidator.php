<?php

namespace app\Validators;

use Grimzy\LaravelMysqlSpatial\Types\Point;

class PointValidator implements Validator
{
    /**
     * @param Point $value
     * @param bool $verify
     * @return bool
     * @throws \InvalidArgumentException
     */
    public static function isValid($value, bool $verify = false): bool
    {
        if (!($value instanceof Point)) {
            if ($verify) {
                throw new \InvalidArgumentException("Given value is not a Point");
            }
            return false;
        }

        $errors = [];
        if (!$value->getLat() && !$value->getLng()) {
            $errors[] = "Empty coordinates";
        }

        if ($value->getLat() < -90 || $value->getLat() > 90) {
            $errors[] = "Invalid latitude {$value->getLat()}";
        }

        if ($value->getLng() < -180 || $value->getLng() > 180) {
            $errors[] = "Invalid longitude {$value->getLng()}";
        }

        if (!$errors) {
            return true;
        }

        if ($verify) {
            throw new \InvalidArgumentException(implode(', ', $errors));
        }

        return false;
    }
}