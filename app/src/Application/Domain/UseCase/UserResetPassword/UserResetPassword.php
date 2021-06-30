<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\UserResetPassword;

use App\Application\Domain\Common\Factory\ErrorResponseFactory\ErrorResponseFromExceptionFactoryInterface;
use App\Application\Domain\Exception\ValidateException;
use App\Application\Domain\Gateway\NotificationGatewayInterface;
use App\Application\Domain\Gateway\UserHashGeneratorGatewayInterface;
use App\Application\Domain\Repository\UserRepositoryInterface;

/**
 * Class UserResetPassword
 * @package App\Application\Domain\UseCase\UserResetPassword
 */
class UserResetPassword
{
    /** @var UserRepositoryInterface */
    private UserRepositoryInterface $userRepository;

    /** @var NotificationGatewayInterface */
    private NotificationGatewayInterface $notificationGateway;

    /** @var UserHashGeneratorGatewayInterface */
    private UserHashGeneratorGatewayInterface $hashGeneratorGateway;

    /** @var ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory */
    private ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory;

    /**
     * UserResetPassword constructor.
     * @param UserRepositoryInterface $userRepository
     * @param NotificationGatewayInterface $notificationGateway
     * @param UserHashGeneratorGatewayInterface $hashGeneratorGateway
     * @param ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory
     */
    public function __construct(UserRepositoryInterface $userRepository, NotificationGatewayInterface $notificationGateway, UserHashGeneratorGatewayInterface $hashGeneratorGateway, ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory)
    {
        $this->userRepository = $userRepository;
        $this->notificationGateway = $notificationGateway;
        $this->hashGeneratorGateway = $hashGeneratorGateway;
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
            if (empty($request->getEmail())) {
                throw new ValidateException("Empty email field");
            }
            $user = $this->userRepository->findOneBy(['email' => $request->getEmail()]);
            if (!$user) {
                throw new ValidateException("Email not exists");
            }
            $hash = $this->hashGeneratorGateway->generate($user);
            $user->setHash($hash);
            $this->userRepository->save($user);
            $this->notificationGateway->userResetPassword($user, $hash);
        } catch (\Throwable $e) {
            $error = $this->errorResponseFromExceptionFactory->create($e);
            $response->setError($error);
        }
        $presenter->present($response);
    }
}
