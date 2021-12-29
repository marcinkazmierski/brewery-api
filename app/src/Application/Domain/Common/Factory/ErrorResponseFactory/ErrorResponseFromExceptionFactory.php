<?php

namespace App\Application\Domain\Common\Factory\ErrorResponseFactory;

use App\Application\Domain\Common\Response\ErrorResponse;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class ErrorResponseFromExceptionFactory implements ErrorResponseFromExceptionFactoryInterface
{
    /** @var TranslatorInterface */
    private TranslatorInterface $translator;
    /** @var LoggerInterface */
    private LoggerInterface $logger;

    /**
     * @param TranslatorInterface $translator
     * @param LoggerInterface $logger
     */
    public function __construct(TranslatorInterface $translator, LoggerInterface $logger)
    {
        $this->translator = $translator;
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

        return new ErrorResponse($errorCode, $message, $this->translator->trans($message));
    }
}
