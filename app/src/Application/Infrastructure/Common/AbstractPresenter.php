<?php

namespace App\Application\Infrastructure\Common;

use App\Application\Domain\Common\Mapper\ErrorResponseFieldMapper;
use App\Application\Domain\Common\Response\ErrorResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class AbstractPresenter
 * @package App\Application\Infrastructure\Common
 */
abstract class AbstractPresenter
{
    /**
     * @param ErrorResponse $errorEntityResponse
     * @param int $statusCode
     * @return JsonResponse
     */
    public function viewErrorResponse(ErrorResponse $errorEntityResponse, int $statusCode = JsonResponse::HTTP_BAD_REQUEST)
    {
        $response = new JsonResponse();
        $response->setData(
            [
                ErrorResponseFieldMapper::ERROR_FIELD => $errorEntityResponse->toArray(),
            ]
        );
        $response->setStatusCode($statusCode);
        return $response;
    }
}
