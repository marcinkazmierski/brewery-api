<?php
declare(strict_types=1);
namespace App\Application\Infrastructure\UseCase\StoreNotificationToken;

use App\Application\Domain\UseCase\StoreNotificationToken\StoreNotificationTokenPresenterInterface;
use App\Application\Domain\UseCase\StoreNotificationToken\StoreNotificationTokenResponse;
use App\Application\Infrastructure\Common\AbstractPresenter;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class StoreNotificationTokenPresenter
 * @package App\Application\Infrastructure\UseCase\StoreNotificationToken
 */
class StoreNotificationTokenPresenter extends AbstractPresenter implements StoreNotificationTokenPresenterInterface
{
    /**
     * @var StoreNotificationTokenResponse $response
     */
    private $response;

    /**
     * @param StoreNotificationTokenResponse $response
     */
    public function present(StoreNotificationTokenResponse $response): void
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
