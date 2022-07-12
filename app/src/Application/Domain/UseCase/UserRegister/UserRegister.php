<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\UserRegister;

use App\Application\Domain\Common\Command\CollectUnlockedBeersCommand;
use App\Application\Domain\Common\Constants\UserStatusConstants;
use App\Application\Domain\Common\Factory\ErrorResponseFactory\ErrorResponseFromExceptionFactoryInterface;
use App\Application\Domain\Entity\User;
use App\Application\Domain\Exception\ValidateException;
use App\Application\Domain\Gateway\NotificationGatewayInterface;
use App\Application\Domain\Gateway\UserHashGeneratorGatewayInterface;
use App\Application\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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

    /** @var UserHashGeneratorGatewayInterface */
    private UserHashGeneratorGatewayInterface $confirmHashGeneratorGateway;

    /** @var CollectUnlockedBeersCommand */
    private CollectUnlockedBeersCommand $collectUnlockedBeersCommand;

    /** @var UserPasswordHasherInterface */
    private UserPasswordHasherInterface $passwordEncoder;

    /** @var ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory */
    private ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory;

    /**
     * @param UserRepositoryInterface $userRepository
     * @param NotificationGatewayInterface $notificationGateway
     * @param UserHashGeneratorGatewayInterface $confirmHashGeneratorGateway
     * @param CollectUnlockedBeersCommand $collectUnlockedBeersCommand
     * @param UserPasswordHasherInterface $passwordEncoder
     * @param ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory
     */
    public function __construct(UserRepositoryInterface $userRepository, NotificationGatewayInterface $notificationGateway, UserHashGeneratorGatewayInterface $confirmHashGeneratorGateway, CollectUnlockedBeersCommand $collectUnlockedBeersCommand, UserPasswordHasherInterface $passwordEncoder, ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory)
    {
        $this->userRepository = $userRepository;
        $this->notificationGateway = $notificationGateway;
        $this->confirmHashGeneratorGateway = $confirmHashGeneratorGateway;
        $this->collectUnlockedBeersCommand = $collectUnlockedBeersCommand;
        $this->passwordEncoder = $passwordEncoder;
        $this->errorResponseFromExceptionFactory = $errorResponseFromExceptionFactory;
    }

    /**
     * @param UserRegisterRequest $request
     * @param UserRegisterPresenterInterface $presenter
     */
    public function execute(
        UserRegisterRequest            $request,
        UserRegisterPresenterInterface $presenter)
    {
        $response = new UserRegisterResponse();
        try {
            if (empty($request->getEmail())) {
                throw new ValidateException("Empty email field");
            }

            if (!filter_var($request->getEmail(), FILTER_VALIDATE_EMAIL)) {
                throw new ValidateException("Invalid email field");
            }
            if (empty($request->getPassword()) || strlen($request->getPassword()) < 8) {
                throw new ValidateException("Invalid password field. Minimum password length: 8");
            }

            if ($this->userRepository->findOneBy(['email' => $request->getEmail()])) {
                throw new ValidateException("Email exists");
            }

            if ($request->getUser()) {
                $user = $request->getUser();
                if ($user->getStatus() == UserStatusConstants::GUEST_WAIT_FOR_CONFIRMATION) {
                    throw new ValidateException("Invalid status. Account is already registered but not confirmed. Please, check your email.");
                }
                if ($user->getStatus() !== UserStatusConstants::GUEST) {
                    throw new ValidateException("Invalid status. Account is already registered.");
                }

                $user->setStatus(UserStatusConstants::GUEST_WAIT_FOR_CONFIRMATION);
            } else {
                if (empty($request->getNick())) {
                    throw new ValidateException("Empty nick field");
                }
                if ($this->userRepository->findOneBy(['nick' => $request->getNick()])) {
                    throw new ValidateException("Nick exists");
                }
                $user = new User();
                $user->setNick($request->getNick());
                $this->collectUnlockedBeersCommand->execute($user);
                $user->setStatus(UserStatusConstants::NEW);
            }

            $user->setEmail($request->getEmail());
            $hash = $this->confirmHashGeneratorGateway->generate($user);
            $user->setHash($hash);
            $encodedPassword = $this->passwordEncoder->hashPassword($user, $request->getPassword());
            $user->setPassword($encodedPassword);
            $this->userRepository->save($user);
            $this->notificationGateway->userRegister($user, $hash);
            $response->setUser($user);
        } catch (\Throwable $e) {
            $error = $this->errorResponseFromExceptionFactory->create($e);
            $response->setError($error);
        }
        $presenter->present($response);
    }
}
