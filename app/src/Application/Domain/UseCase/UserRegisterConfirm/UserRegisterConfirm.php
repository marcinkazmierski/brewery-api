<?php
declare(strict_types=1);
namespace App\Application\Domain\UseCase\UserRegisterConfirm;

use App\Application\Domain\Common\Factory\ErrorResponseFactory\ErrorResponseFromExceptionFactoryInterface;

/**
 * Class UserRegisterConfirm
 * @package App\Application\Domain\UseCase\UserRegisterConfirm
 */
class UserRegisterConfirm
{
    /** @var ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory */
    private $errorResponseFromExceptionFactory;

    /**
     * UserRegisterConfirm constructor.
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
     * @param UserRegisterConfirmRequest $request
     * @param UserRegisterConfirmPresenterInterface $presenter
     */
    public function execute(
        UserRegisterConfirmRequest $request,
        UserRegisterConfirmPresenterInterface $presenter)
    {
        $response = new UserRegisterConfirmResponse();
        try {
            //TODO
        } catch (\Throwable $e) {
            $error = $this->errorResponseFromExceptionFactory->create($e);
            $response->setError($error);
        }
        $presenter->present($response);
    }
}
