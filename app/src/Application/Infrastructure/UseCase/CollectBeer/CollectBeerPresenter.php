<?php
declare(strict_types=1);
namespace App\Application\Infrastructure\UseCase\CollectBeer;

use App\Application\Domain\UseCase\CollectBeer\CollectBeerPresenterInterface;
use App\Application\Domain\UseCase\CollectBeer\CollectBeerResponse;
use App\Application\Infrastructure\Common\AbstractPresenter;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class CollectBeerPresenter
 * @package App\Application\Infrastructure\UseCase\CollectBeer
 */
class CollectBeerPresenter extends AbstractPresenter implements CollectBeerPresenterInterface
{
    /**
     * @var CollectBeerResponse $response
     */
    private $response;

    /**
     * @param CollectBeerResponse $response
     */
    public function present(CollectBeerResponse $response): void
    {
        $this->response = $response;
    }

    /**
     * @return JsonResponse
     */
    public function view()
    {
        if ($this->response->hasError()) {
            $statusCode = JsonResponse::HTTP_BAD_REQUEST;
            return $this->viewErrorResponse($this->response->getError(), $statusCode);
        }
        
        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
