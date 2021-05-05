<?php

namespace App\Application\Domain\Common\Mapper;

abstract class ErrorResponseFieldMapper
{
    const ERROR_FIELD = 'error';

    const CODE = 'code';
    const MESSAGE = 'message';
    const USER_MESSAGE = 'userMessage';
}
