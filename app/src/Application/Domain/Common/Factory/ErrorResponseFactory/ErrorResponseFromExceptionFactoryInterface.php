<?php

namespace App\Application\Domain\Common\Factory\ErrorResponseFactory;


use App\Application\Domain\Common\Response\ErrorResponse;

interface ErrorResponseFromExceptionFactoryInterface
{
    /**
     * @param \Throwable $exception
     * @return ErrorResponse
     */
    public function create(\Throwable $exception): ErrorResponse;
}
