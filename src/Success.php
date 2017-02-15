<?php

namespace Sassnowski\Result;

class Success extends Result
{
    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isFailure(): bool
    {
        return false;
    }
}
