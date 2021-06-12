<?php
declare(strict_types=1);
namespace App\Application\Infrastructure\UseCase\UserResetPassword;

use App\Application\Domain\UseCase\UserResetPassword\UserResetPasswordPresenterInterface;
use App\Application\Domain\UseCase\UserResetPassword\UserResetPasswordResponse;
use App\Application\Infrastructure\Common\AbstractPresenter;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class UserResetPasswordPresenter
 * @package App\Application\Infrastructure\UseCase\UserResetPassword
 */
class UserResetPasswordPresenter extends AbstractPresenter implements UserResetPasswordPresenterInterface
{
    /**
     * @var UserResetPasswordResponse $response
     */
    private $response;

    /**
     * @param UserResetPasswordResponse $response
     */
    public function present(UserResetPasswordResponse $response): void
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
