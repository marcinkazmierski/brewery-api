<?php
declare(strict_types=1);
namespace App\Application\Infrastructure\UseCase\UserRegister;

use App\Application\Domain\UseCase\UserRegister\UserRegisterPresenterInterface;
use App\Application\Domain\UseCase\UserRegister\UserRegisterResponse;
use App\Application\Infrastructure\Common\AbstractPresenter;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class UserRegisterPresenter
 * @package App\Application\Infrastructure\UseCase\UserRegister
 */
class UserRegisterPresenter extends AbstractPresenter implements UserRegisterPresenterInterface
{
    /**
     * @var UserRegisterResponse $response
     */
    private $response;

    /**
     * @param UserRegisterResponse $response
     */
    public function present(UserRegisterResponse $response): void
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
