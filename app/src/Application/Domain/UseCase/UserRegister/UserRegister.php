<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\UserRegister;

use App\Application\Domain\Common\Factory\ErrorResponseFactory\ErrorResponseFromExceptionFactoryInterface;
use App\Application\Domain\Entity\User;
use App\Application\Domain\Exception\ValidateException;
use App\Application\Domain\Gateway\NotificationGatewayInterface;
use App\Application\Domain\Gateway\UserRegistrationConfirmHashGeneratorGatewayInterface;
use App\Application\Domain\Repository\UserRepositoryInterface;

/**
 * Class UserRegister
 * @package App\Application\Domain\UseCase\UserRegister
 */
class UserRegister
{
    /** @var UserRepositoryInterface */
    private UserRepositoryInterface $userRepository;

    /** @var NotificationGatewayInterface */
    private NotificationGatewayInterface $notificationGateway;

    /** @var UserRegistrationConfirmHashGeneratorGatewayInterface */
    private UserRegistrationConfirmHashGeneratorGatewayInterface $confirmHashGeneratorGateway;

    /** @var ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory */
    private ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory;

    /**
     * UserRegister constructor.
     * @param UserRepositoryInterface $userRepository
     * @param NotificationGatewayInterface $notificationGateway
     * @param UserRegistrationConfirmHashGeneratorGatewayInterface $confirmHashGeneratorGateway
     * @param ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory
     */
    public function __construct(UserRepositoryInterface $userRepository, NotificationGatewayInterface $notificationGateway, UserRegistrationConfirmHashGeneratorGatewayInterface $confirmHashGeneratorGateway, ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory)
    {
        $this->userRepository = $userRepository;
        $this->notificationGateway = $notificationGateway;
        $this->confirmHashGeneratorGateway = $confirmHashGeneratorGateway;
        $this->errorResponseFromExceptionFactory = $errorResponseFromExceptionFactory;
    }

    /**
     * @param UserRegisterRequest $request
     * @param UserRegisterPresenterInterface $presenter
     */
    public function execute(
        UserRegisterRequest $request,
        UserRegisterPresenterInterface $presenter)
    {
        $response = new UserRegisterResponse();
        try {
            if (empty($request->getEmail())) {
                throw new ValidateException("Empty email field");
            }
            if (empty($request->getNick())) {
                throw new ValidateException("Empty nick field");
            }
            if (!filter_var($request->getEmail(), FILTER_VALIDATE_EMAIL)) {
                throw new ValidateException("Invalid email field");
            }
            if ($this->userRepository->findOneBy(['nick' => $request->getNick()])) {
                throw new ValidateException("Nick exists");
            }
            if ($this->userRepository->findOneBy(['email' => $request->getEmail()])) {
                throw new ValidateException("Email exists");
            }
            $user = new User();
            $user->setEmail($request->getEmail());
            $user->setNick($request->getNick());
            $this->userRepository->save($user);
            $hash = $this->confirmHashGeneratorGateway->generate($user);
            $this->notificationGateway->userRegister($user, $hash);
            $response->setUser($user);
        } catch (\Throwable $e) {
            $error = $this->errorResponseFromExceptionFactory->create($e);
            $response->setError($error);
        }
        $presenter->present($response);
    }
}
