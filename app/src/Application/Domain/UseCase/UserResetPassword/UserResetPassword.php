<?php
declare(strict_types=1);
namespace App\Application\Domain\UseCase\UserResetPassword;

use App\Application\Domain\Common\Factory\ErrorResponseFactory\ErrorResponseFromExceptionFactoryInterface;

/**
 * Class UserResetPassword
 * @package App\Application\Domain\UseCase\UserResetPassword
 */
class UserResetPassword
{
    /** @var ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory */
    private $errorResponseFromExceptionFactory;

    /**
     * UserResetPassword constructor.
     * @param ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory
     */
    public function __construct
    (
        ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory
    )
    {
        $this->errorResponseFromExceptionFactory = $errorResponseFromExceptionFactory;
    }

    /**
     * @param UserResetPasswordRequest $request
     * @param UserResetPasswordPresenterInterface $presenter
     */
    public function execute(
        UserResetPasswordRequest $request,
        UserResetPasswordPresenterInterface $presenter)
    {
        $response = new UserResetPasswordResponse();
        try {
            //TODO
        } catch (\Throwable $e) {
            $error = $this->errorResponseFromExceptionFactory->create($e);
            $response->setError($error);
        }
        $presenter->present($response);
    }
}
