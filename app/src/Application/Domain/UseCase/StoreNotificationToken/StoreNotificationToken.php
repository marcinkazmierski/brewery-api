<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\StoreNotificationToken;

use App\Application\Domain\Common\Factory\ErrorResponseFactory\ErrorResponseFromExceptionFactoryInterface;
use App\Application\Domain\Exception\ValidateException;
use App\Application\Domain\Repository\UserRepositoryInterface;

/**
 * Class StoreNotificationToken
 * @package App\Application\Domain\UseCase\StoreNotificationToken
 */
class StoreNotificationToken
{
    private ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory;

    /** @var UserRepositoryInterface */
    private UserRepositoryInterface $userRepository;

    /**
     * @param ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory, UserRepositoryInterface $userRepository)
    {
        $this->errorResponseFromExceptionFactory = $errorResponseFromExceptionFactory;
        $this->userRepository = $userRepository;
    }

    /**
     * @param StoreNotificationTokenRequest $request
     * @param StoreNotificationTokenPresenterInterface $presenter
     */
    public function execute(
        StoreNotificationTokenRequest            $request,
        StoreNotificationTokenPresenterInterface $presenter)
    {
        $response = new StoreNotificationTokenResponse();
        try {
            if (empty($request->getToken())) {
                throw new ValidateException("Empty token field");
            }

            foreach ($this->userRepository->findByCriteria(['notificationToken' => $request->getToken()]) as $u) {
                $u->setNotificationToken(null);
                $this->userRepository->save($u);
            }

            $user = $request->getUser();
            $user->setNotificationToken($request->getToken());
            $this->userRepository->save($user);
        } catch (\Throwable $e) {
            $error = $this->errorResponseFromExceptionFactory->create($e);
            $response->setError($error);
        }
        $presenter->present($response);
    }
}
