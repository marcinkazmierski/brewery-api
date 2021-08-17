<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\GetUserProfile;

use App\Application\Domain\Common\Factory\ErrorResponseFactory\ErrorResponseFromExceptionFactoryInterface;

/**
 * Class GetUserProfile
 * @package App\Application\Domain\UseCase\GetUserProfile
 */
class GetUserProfile
{
    /** @var ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory */
    private $errorResponseFromExceptionFactory;

    /**
     * GetUserProfile constructor.
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
     * @param GetUserProfileRequest $request
     * @param GetUserProfilePresenterInterface $presenter
     */
    public function execute(
        GetUserProfileRequest            $request,
        GetUserProfilePresenterInterface $presenter)
    {
        $response = new GetUserProfileResponse();
        try {
            $response->setUser($request->getUser());
        } catch (\Throwable $e) {
            $error = $this->errorResponseFromExceptionFactory->create($e);
            $response->setError($error);
        }
        $presenter->present($response);
    }
}
