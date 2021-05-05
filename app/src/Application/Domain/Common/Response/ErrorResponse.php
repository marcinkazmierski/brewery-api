<?php

namespace App\Application\Domain\Common\Response;

use App\Application\Domain\Common\Mapper\ErrorResponseFieldMapper;

/**
 * Class ErrorResponse
 * @package App\Application\Domain\Common
 */
class ErrorResponse
{
    /**
     * @var string
     */
    protected $code;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var string
     */
    protected $userMessage;

    /**
     * ErrorResponse constructor.
     * @param string $code
     * @param string $message
     * @param string $userMessage
     */
    public function __construct(string $code, string $message, string $userMessage)
    {
        $this->code = $code;
        $this->message = $message;
        $this->userMessage = $userMessage;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getUserMessage(): string
    {
        return $this->userMessage;
    }


    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            ErrorResponseFieldMapper::CODE => $this->getCode(),
            ErrorResponseFieldMapper::MESSAGE => $this->getMessage(),
            ErrorResponseFieldMapper::USER_MESSAGE => $this->getUserMessage(),
        ];
    }
}
