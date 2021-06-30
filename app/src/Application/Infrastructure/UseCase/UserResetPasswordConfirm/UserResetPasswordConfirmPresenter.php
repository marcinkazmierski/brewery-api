<?php
declare(strict_types=1);
namespace App\Application\Infrastructure\UseCase\UserResetPasswordConfirm;

use App\Application\Domain\UseCase\UserResetPasswordConfirm\UserResetPasswordConfirmPresenterInterface;
use App\Application\Domain\UseCase\UserResetPasswordConfirm\UserResetPasswordConfirmResponse;
use App\Application\Infrastructure\Common\AbstractPresenter;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class UserResetPasswordConfirmPresenter
 * @package App\Application\Infrastructure\UseCase\UserResetPasswordConfirm
 */
class UserResetPasswordConfirmPresenter extends AbstractPresenter implements UserResetPasswordConfirmPresenterInterface
{
    /**
     * @var UserResetPasswordConfirmResponse $response
     */
    private $response;

    /**
     * @param UserResetPasswordConfirmResponse $response
     */
    public function present(UserResetPasswordConfirmResponse $response): void
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
