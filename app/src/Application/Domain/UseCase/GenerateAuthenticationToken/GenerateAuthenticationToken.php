<?php
declare(strict_types=1);
namespace App\Application\Domain\UseCase\GenerateAuthenticationToken;

use App\Application\Domain\Common\Factory\ErrorResponseFactory\ErrorResponseFromExceptionFactoryInterface;
use App\Application\Infrastructure\Repository\UserRepository;
use App\Application\Infrastructure\Repository\UserTokenRepository;

/**
 * Class GenerateAuthenticationToken
 * @package App\Application\Domain\UseCase\GenerateAuthenticationToken
 */
class GenerateAuthenticationToken
{
    /** @var UserRepository */
    private $userRepository;

    /** @var UserTokenRepository */
    private $userTokenRepository;

    /** @var ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory */
    private $errorResponseFromExceptionFactory;

    /**
     * GenerateAuthenticationToken constructor.
     * @param UserRepository $userRepository
     * @param UserTokenRepository $userTokenRepository
     * @param ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory
     */
    public function __construct(UserRepository $userRepository, UserTokenRepository $userTokenRepository, ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory)
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
