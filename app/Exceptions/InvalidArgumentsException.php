<?php /** @noinspection PhpUnused */

namespace app\Exceptions;

use Throwable;

class InvalidArgumentsException extends \Exception
{
    protected array $errors = [];

    public function __construct(array $errors, $code = 0, Throwable $previous = null)
    {
        $this->errors = $errors;
        parent::__construct(json_encode($errors), $code, $previous);
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     * @return InvalidArgumentsException
     */
    public function setErrors(array $errors): InvalidArgumentsException
    {
        $this->errors = $errors;
        return $this;
    }
}