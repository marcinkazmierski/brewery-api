<?php

namespace App\Application\Domain\Common\Factory\ErrorResponseFactory;

use App\Application\Domain\Common\Response\ErrorResponse;
use Psr\Log\LoggerInterface;

class ErrorResponseFromExceptionFactory implements ErrorResponseFromExceptionFactoryInterface
{
    /** @var LoggerInterface */
    private $logger;

    /**
     * ErrorResponseFromExceptionFactory constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param \Throwable $exception
     * @return ErrorResponse
     */
    public function create(\Throwable $exception): ErrorResponse
    {
        $this->logger->error('ErrorResponseFromExceptionFactory:create', [
            'exception_class' => get_class($exception),
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
        ]);
        $message = $exception->getMessage();

        $errorCode = 1000; //todo
        //todo: translate user message!
        return new ErrorResponse($errorCode, $message, $message);
    }
}
