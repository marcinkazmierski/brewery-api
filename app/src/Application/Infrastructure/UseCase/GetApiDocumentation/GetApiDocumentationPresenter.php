<?php
declare(strict_types=1);

namespace App\Application\Infrastructure\UseCase\GetApiDocumentation;

use App\Application\Domain\UseCase\GetApiDocumentation\GetApiDocumentationPresenterInterface;
use App\Application\Domain\UseCase\GetApiDocumentation\GetApiDocumentationResponse;
use App\Application\Infrastructure\Common\AbstractPresenter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class GetApiDocumentationPresenter
 * @package App\Application\Infrastructure\UseCase\GetApiDocumentation
 */
class GetApiDocumentationPresenter extends AbstractPresenter implements GetApiDocumentationPresenterInterface
{
    /**
     * @var GetApiDocumentationResponse $response
     */
    private $response;

    /**
     * @param GetApiDocumentationResponse $response
     */
    public function present(GetApiDocumentationResponse $response): void
    {
        $this->response = $response;
    }

    /**
     * @return Response
     */
    public function view()
    {
        if ($this->response->hasError()) {
            $statusCode = JsonResponse::HTTP_BAD_REQUEST;
            return new Response($this->response->getError()->getUserMessage(), $statusCode);
        }

        return new Response($this->response->getApiDocumentation(), Response::HTTP_OK);
    }
}
