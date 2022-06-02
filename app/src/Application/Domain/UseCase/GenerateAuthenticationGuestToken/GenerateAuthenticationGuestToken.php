<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\GenerateAuthenticationGuestToken;

use App\Application\Domain\Common\Command\CollectUnlockedBeersCommand;
use App\Application\Domain\Common\Constants\UserStatusConstants;
use App\Application\Domain\Common\Factory\ErrorResponseFactory\ErrorResponseFromExceptionFactoryInterface;
use App\Application\Domain\Entity\User;
use App\Application\Domain\Exception\ValidateException;
use App\Application\Domain\Repository\UserRepositoryInterface;
use App\Application\Domain\Repository\UserTokenRepositoryInterface;

/**
 * Class GenerateAuthenticationGuestToken
 * @package App\Application\Domain\UseCase\GenerateAuthenticationGuestToken
 */
class GenerateAuthenticationGuestToken
{
    /** @var UserRepositoryInterface */
    private UserRepositoryInterface $userRepository;

    /** @var UserTokenRepositoryInterface */
    private UserTokenRepositoryInterface $userTokenRepository;

    /** @var CollectUnlockedBeersCommand */
    private CollectUnlockedBeersCommand $collectUnlockedBeersCommand;

    /** @var ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory */
    private ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory;

    /**
     * @param UserRepositoryInterface $userRepository
     * @param UserTokenRepositoryInterface $userTokenRepository
     * @param CollectUnlockedBeersCommand $collectUnlockedBeersCommand
     * @param ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory
     */
    public function __construct(UserRepositoryInterface $userRepository, UserTokenRepositoryInterface $userTokenRepository, CollectUnlockedBeersCommand $collectUnlockedBeersCommand, ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory)
    {
        $this->userRepository = $userRepository;
        $this->userTokenRepository = $userTokenRepository;
        $this->collectUnlockedBeersCommand = $collectUnlockedBeersCommand;
        $this->errorResponseFromExceptionFactory = $errorResponseFromExceptionFactory;
    }

    /**
     * @param GenerateAuthenticationGuestTokenRequest $request
     * @param GenerateAuthenticationGuestTokenPresenterInterface $presenter
     */
    public function execute(
        GenerateAuthenticationGuestTokenRequest            $request,
        GenerateAuthenticationGuestTokenPresenterInterface $presenter)
    {
        $response = new GenerateAuthenticationGuestTokenResponse();
        try {
            if (strlen($request->getNick()) < 3) {
                throw new ValidateException("Nick too short. Min 3 chars.");
            }

            if ($this->userRepository->findOneBy(['nick' => $request->getNick()])) {
                throw new ValidateException("Nick exists");
            }

            $user = new User();
            $user->setStatus(UserStatusConstants::GUEST);
            $user->setNick($request->getNick());
            $this->userRepository->save($user);
            $this->collectUnlockedBeersCommand->execute($user);
            $response->setUser($user);

            $token = $this->userTokenRepository->generateToken($user, $request->getAppVersion());
            $response->setTokenKey($token->getTokenKey());
        } catch (\Throwable $e) {
            $error = $this->errorResponseFromExceptionFactory->create($e);
            $response->setError($error);
        }
        $presenter->present($response);
    }
}
