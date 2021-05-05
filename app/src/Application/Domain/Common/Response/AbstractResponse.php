<?php

namespace App\Application\Domain\Common\Response;

/**
 * Class AbstractResponse
 * @package App\Application\Domain\Common
 */
abstract class AbstractResponse
{
    /** @var ErrorResponse */
    protected $error;

    /**
     * @return ErrorResponse
     */
    public function getError(): ErrorResponse
    {
        return $this->error;
    }

    /**
     * @param ErrorResponse $error
     */
    public function setError(ErrorResponse $error): void
    {
        $this->error = $error;
    }

    /**
     * @return bool
     */
    public function hasError()
    {
        return is_object($this->error);
    }
}
