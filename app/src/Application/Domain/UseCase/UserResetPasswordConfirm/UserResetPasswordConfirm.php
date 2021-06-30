<?php
declare(strict_types=1);
namespace App\Application\Domain\UseCase\UserResetPasswordConfirm;

use App\Application\Domain\Common\Factory\ErrorResponseFactory\ErrorResponseFromExceptionFactoryInterface;

/**
 * Class UserResetPasswordConfirm
 * @package App\Application\Domain\UseCase\UserResetPasswordConfirm
 */
class UserResetPasswordConfirm
{
    /** @var ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory */
    private $errorResponseFromExceptionFactory;

    /**
     * UserResetPasswordConfirm constructor.
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
     * @param UserResetPasswordConfirmRequest $request
     * @param UserResetPasswordConfirmPresenterInterface $presenter
     */
    public function execute(
        UserResetPasswordConfirmRequest $request,
        UserResetPasswordConfirmPresenterInterface $presenter)
    {
        $response = new UserResetPasswordConfirmResponse();
        try {
            //TODO
            // todo: validate HashExpiryDate
        } catch (\Throwable $e) {
            $error = $this->errorResponseFromExceptionFactory->create($e);
            $response->setError($error);
        }
        $presenter->present($response);
    }
}
