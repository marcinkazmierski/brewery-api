<?php
declare(strict_types=1);

namespace App\Security;

use App\Application\Domain\Common\Factory\ErrorResponseFactory\ErrorResponseFromExceptionFactoryInterface;
use App\Application\Infrastructure\Repository\UserTokenRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class TokenAuthenticatorMiddleware extends AbstractAuthenticator
{
    const AUTHENTICATION_WHITELIST = [
        '#/api/auth/authenticate$#',
        '#/api/auth/authenticate/guest$#',
        '#/api/register$#',
        '#/api/register/activate/(.+)#',
        '#/api/auth/reset-password$#',
    ];

    /** @var UserTokenRepository */
    private UserTokenRepository $userTokenRepository;

    /** @var ErrorResponseFromExceptionFactoryInterface */
    private ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory;

    /**
     * TokenAuthenticatorMiddleware constructor.
     * @param UserTokenRepository $userTokenRepository
     * @param ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory
     */
    public function __construct(UserTokenRepository $userTokenRepository, ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory)
    {
        $this->userTokenRepository = $userTokenRepository;
        $this->errorResponseFromExceptionFactory = $errorResponseFromExceptionFactory;
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
     * @param Request $request
     * @return Passport
     * @throws \Exception
     */
    public function authenticate(Request $request): Passport
    {
        $credentials = (string)$request->headers->get('X-AUTH-TOKEN');
        if (empty($credentials)) {
            throw new AuthenticationException("Unauthorized: empty X-AUTH-TOKEN header field.");
        }

		try {
			$token = $this->userTokenRepository->getTokenByTokenKey($credentials);
		} catch (\Throwable $exception) {
			throw new AuthenticationException($exception->getMessage());
		}

        return new SelfValidatingPassport(new UserBadge($token->getUser()->getUserIdentifier()), []);
    }
}