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
     * @var \stdClass
     */
    protected $additional;

    /**
     * ErrorResponse constructor.
     * @param string $code
     * @param string $message
     * @param string $userMessage
     * @param \stdClass|null $additional
     */
    public function __construct(string $code, string $message, string $userMessage, \stdClass $additional = null)
    {
        $this->code = $code;
        $this->message = $message;
        $this->userMessage = $userMessage;
        $this->additional = $additional ?? new \stdClass();
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
     * @return \stdClass
     */
    public function getAdditional(): \stdClass
    {
        return $this->additional;
    }


    /**
     * @return array
     */
    public function toArray()
    {
        return [
            ErrorResponseFieldMapper::CODE => $this->getCode(),
            ErrorResponseFieldMapper::MESSAGE => $this->getMessage(),
            ErrorResponseFieldMapper::USER_MESSAGE => $this->getUserMessage(),
            ErrorResponseFieldMapper::ADDITIONAL => $this->getAdditional(),
        ];
    }
}
