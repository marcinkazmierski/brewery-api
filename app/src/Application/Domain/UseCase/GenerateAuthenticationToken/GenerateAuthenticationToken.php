<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\GenerateAuthenticationToken;

use App\Application\Domain\Common\Constants\UserStatusConstants;
use App\Application\Domain\Common\Factory\ErrorResponseFactory\ErrorResponseFromExceptionFactoryInterface;
use App\Application\Domain\Exception\ValidateException;
use App\Application\Domain\Repository\UserRepositoryInterface;
use App\Application\Domain\Repository\UserTokenRepositoryInterface;

/**
 * Class GenerateAuthenticationToken
 * @package App\Application\Domain\UseCase\GenerateAuthenticationToken
 */
class GenerateAuthenticationToken
{
    /** @var UserRepositoryInterface */
    private UserRepositoryInterface $userRepository;

    /** @var UserTokenRepositoryInterface */
    private UserTokenRepositoryInterface $userTokenRepository;

    /** @var ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory */
    private ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory;

    /**
     * GenerateAuthenticationToken constructor.
     * @param UserRepositoryInterface $userRepository
     * @param UserTokenRepositoryInterface $userTokenRepository
     * @param ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory
     */
    public function __construct(UserRepositoryInterface $userRepository, UserTokenRepositoryInterface $userTokenRepository, ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory)
    {
        $this->userRepository = $userRepository;
        $this->userTokenRepository = $userTokenRepository;
        $this->errorResponseFromExceptionFactory = $errorResponseFromExceptionFactory;
    }


    /**
     * @param GenerateAuthenticationTokenRequest $request
     * @param GenerateAuthenticationTokenPresenterInterface $presenter
     */
    public function execute(
        GenerateAuthenticationTokenRequest $request,
        GenerateAuthenticationTokenPresenterInterface $presenter)
    {
        $response = new GenerateAuthenticationTokenResponse();
        try {
            $user = $this->userRepository->getUserByEmailAndPassword($request->getEmail(), $request->getPassword());
            if ($user->getStatus() !== UserStatusConstants::ACTIVE) {
                throw new ValidateException("Invalid user status");
            }
            $token = $this->userTokenRepository->generateToken($user, $request->getAppVersion());
            $response->setTokenKey($token->getTokenKey());
            $response->setUser($user);
        } catch (\Throwable $e) {
            $error = $this->errorResponseFromExceptionFactory->create($e);
            $response->setError($error);
        }
        $presenter->present($response);
    }
}
