<?php

namespace Sassnowski\Result;

class Failure extends Result
{
    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    public function isFailure(): bool
    {
        return true;
    }
}
