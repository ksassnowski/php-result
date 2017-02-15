<?php

namespace Sassnowski\Result;

abstract class Result
{
    /**
     * @var mixed
     */
    protected $value;

    /**
     * Result constructor.
     *
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @param $value
     *
     * @return Success
     */
    public static function success($value): Success
    {
        return new Success($value);
    }

    /**
     * @param $value
     *
     * @return Failure
     */
    public static function failure($value): Failure
    {
        return new Failure($value);
    }

    /**
     * @param $value
     *
     * @return Success
     */
    public static function from($value): Success
    {
        return self::success($value);
    }

    /**
     * @return bool
     */
    public abstract function isSuccess(): bool;

    /**
     * @return bool
     */
    public abstract function isFailure(): bool;

    /**
     * @param callable $f
     *
     * @return Result
     */
    public function bind(callable $f): Result
    {
        if ($this->isFailure()) {
            return $this;
        }

        return $f($this->value);
    }

    /**
     * @return mixed
     */
    public function get()
    {
        return $this->value;
    }
}
