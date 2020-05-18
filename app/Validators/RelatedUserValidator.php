<?php

namespace app\Validators;

use App\User;

class RelatedUserValidator implements Validator
{
    /**
     * @param User $value
     * @param bool $verify
     * @return bool
     * @throws \InvalidArgumentException
     */
    public static function isValid($value, bool $verify = false): bool
    {
        if (!($value instanceof User)) {
            if ($verify) {
                throw new \InvalidArgumentException("Given value is not a User");
            }
            return false;
        }

        $errors = [];
        if (!$value->id) {
            $errors[] = "ID is empty";
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