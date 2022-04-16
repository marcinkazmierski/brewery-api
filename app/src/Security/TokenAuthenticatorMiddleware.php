<?php
declare(strict_types=1);

namespace App\Security;


use App\Application\Domain\Common\Factory\ErrorResponseFactory\ErrorResponseFromExceptionFactoryInterface;
use App\Application\Infrastructure\Repository\UserTokenRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class TokenAuthenticatorMiddleware extends AbstractGuardAuthenticator
{
    const AUTHENTICATION_WHITELIST = [
        '#/api/auth/authenticate$#',
        '#/api/register$#',
        '#/api/register/activate/(.+)#',
        '#/api/auth/reset-password$#',
    ];

    /** @var UserTokenRepository */
    private UserTokenRepository $userTokenRepository;

    /** @var ErrorResponseFromExceptionFactoryInterface */
    private ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory;

    /** @var LoggerInterface */
    private LoggerInterface $logger;

    /**
     * TokenAuthenticatorMiddleware constructor.
     * @param UserTokenRepository $userTokenRepository
     * @param ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory
     * @param LoggerInterface $logger
     */
    public function __construct(UserTokenRepository $userTokenRepository, ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory, LoggerInterface $logger)
    {
        $this->userTokenRepository = $userTokenRepository;
        $this->errorResponseFromExceptionFactory = $errorResponseFromExceptionFactory;
        $this->logger = $logger;
    }


    /**
     * Called on every request to decide if this authenticator should be
     * used for the request. Returning `false` will cause this authenticator
     * to be skipped.
     */
    public function supports(Request $request): bool
    {
        foreach (self::AUTHENTICATION_WHITELIST as $item) {
            if (preg_match_all($item, $request->getRequestUri(), $result)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Called on every request. Return whatever credentials you want to
     * be passed to getUser() as $credentials.
     */
    public function getCredentials(Request $request): string
    {
        return (string)$request->headers->get('X-AUTH-TOKEN');
    }

    public function getUser($credentials, UserProviderInterface $userProvider): ?UserInterface
    {
        if (empty($credentials) || !is_string($credentials)) {
            // The token header was empty, authentication fails with HTTP Status
            // Code 401 "Unauthorized"
            throw new AuthenticationException("Unauthorized: empty X-AUTH-TOKEN header field.");
        }
        $token = $this->userTokenRepository->getTokenByTokenKey($credentials);
        // The "username" in this case is the apiToken, see the key `property`
        // of `your_db_provider` in `security.yaml`.
        // If this returns a user, checkCredentials() is called next:
        return $userProvider->loadUserByUsername($token->getUser()->getUsername());
    }

    public function checkCredentials($credentials, UserInterface $user): bool
    {
        // Check credentials - e.g. make sure the password is valid.
        // In case of an API token, no credential check is needed.

        // Return `true` to cause authentication success
        return true;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey): ?Response
    {
        // on success, let the request continue
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $error = $this->errorResponseFromExceptionFactory->create($exception);
        return new JsonResponse($error->toArray(), Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Called when authentication is needed, but it's not sent
     */
    public function start(Request $request, AuthenticationException $authException = null): Response
    {
        $data = [
            // you might translate this message
            'message' => 'Authentication Required'
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    public function supportsRememberMe(): bool
    {
        return false;
    }
}