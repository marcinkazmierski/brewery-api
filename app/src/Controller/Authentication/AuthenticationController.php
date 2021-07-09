<?php
declare(strict_types=1);

namespace App\Controller\Authentication;

use App\Application\Domain\Common\Mapper\RequestFieldMapper;
use App\Application\Domain\UseCase\GenerateAuthenticationToken\GenerateAuthenticationToken;
use App\Application\Domain\UseCase\GenerateAuthenticationToken\GenerateAuthenticationTokenPresenterInterface;
use App\Application\Domain\UseCase\GenerateAuthenticationToken\GenerateAuthenticationTokenRequest;
use App\Application\Domain\UseCase\UserResetPassword\UserResetPassword;
use App\Application\Domain\UseCase\UserResetPassword\UserResetPasswordPresenterInterface;
use App\Application\Domain\UseCase\UserResetPassword\UserResetPasswordRequest;
use App\Application\Domain\UseCase\UserResetPasswordConfirm\UserResetPasswordConfirm;
use App\Application\Domain\UseCase\UserResetPasswordConfirm\UserResetPasswordConfirmPresenterInterface;
use App\Application\Domain\UseCase\UserResetPasswordConfirm\UserResetPasswordConfirmRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

/**
 * Class AuthenticationController
 * @package App\Controller\Authentication
 */
#[Route('/api/auth')]
class AuthenticationController extends AbstractController
{

    /**
     * User authentication
     *
     * @OA\Post(
     *     path="/api/auth/authenticate",
     *     description="User authentication. Receive access token for further auth.",
     *     tags = {"Authentication"},
     *     @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          type = "object",
     *          @OA\Property(property="email", ref="#/components/schemas/email"),
     *          @OA\Property(property="password", ref="#/components/schemas/password"),
     *          @OA\Property(property="appVersion", ref="#/components/schemas/text")
     *      ),
     *     ),
     *     @OA\Response(
     *      response="200",
     *      description="Return user X-AUTH-TOKEN",
     *      @OA\JsonContent(
     *          type = "object",
     *          @OA\Property(property="token", description="User auth access token", ref="#/components/schemas/token"),
     *          @OA\Property(property="userId", description="User ID", ref="#/components/schemas/userId"),
     *          @OA\Property(property="email", description="User ID", ref="#/components/schemas/email"),
     *          @OA\Property(property="userNick", description="User ID", ref="#/components/schemas/nick")
     *      )
     *     ),
     *     @OA\Response(response="400", ref="#/components/responses/badRequest"),
     *     @OA\Response(response="500", ref="#/components/responses/generalError"),
     * ),
     * @param Request $request
     * @param GenerateAuthenticationToken $authentication
     * @param GenerateAuthenticationTokenPresenterInterface $presenter
     * @return JsonResponse
     */
    #[Route('/authenticate', name: 'authenticate', methods: ['POST'])]
    public function authenticate(
        Request $request,
        GenerateAuthenticationToken $authentication,
        GenerateAuthenticationTokenPresenterInterface $presenter
    ): JsonResponse
    {
        $content = json_decode($request->getContent(), true);
        $email = (string)($content[RequestFieldMapper::EMAIL] ?? '');
        $password = (string)($content[RequestFieldMapper::PASSWORD] ?? '');
        $appVersion = (string)($content[RequestFieldMapper::APP_VERSION] ?? '');

        $authenticationRequest = new GenerateAuthenticationTokenRequest($email, $password, $appVersion);
        $authentication->execute($authenticationRequest, $presenter);
        return $presenter->view();
    }

    //todo: swagger
    #[Route('/logout', name: 'logout', methods: ['POST'])]
    public function logout(
        Request $request): JsonResponse
    {
        // @todo: remove all tokens
        return new JsonResponse(null, JsonResponse::HTTP_OK);
    }

    /**
     * Reset password.
     * @OA\Post(
     *     path="/api/auth/reset-password",
     *     description="Reset password",
     *     tags = {"Authentication"},
     *     @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          type = "object",
     *          @OA\Property(property="email", ref="#/components/schemas/email")
     *      ),
     *     ),
     *     @OA\Response(response="204", ref="#/components/responses/noContent"),
     *     @OA\Response(response="400", ref="#/components/responses/badRequest"),
     *     @OA\Response(response="500", ref="#/components/responses/generalError"),
     * ),
     * @param Request $request
     * @param UserResetPassword $useCase
     * @param UserResetPasswordPresenterInterface $presenter
     * @return JsonResponse
     */
    #[Route('/reset-password', name: 'reset-password', methods: ['POST'])]
    public function resetPassword(
        Request $request,
        UserResetPassword $useCase,
        UserResetPasswordPresenterInterface $presenter
    ): JsonResponse
    {
        $content = json_decode($request->getContent(), true);
        $email = (string)($content[RequestFieldMapper::EMAIL] ?? '');

        $input = new UserResetPasswordRequest($email);
        $useCase->execute($input, $presenter);
        return $presenter->view();
    }

    /**
     * Reset password confirm.
     * @OA\Post(
     *     path="/api/auth/reset-password-confirm",
     *     description="Reset password confirm",
     *     tags = {"Authentication"},
     *     @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          type = "object",
     *          @OA\Property(property="email", ref="#/components/schemas/email"),
     *          @OA\Property(property="newPassword", ref="#/components/schemas/password"),
     *          @OA\Property(property="code", ref="#/components/schemas/text")
     *      ),
     *     ),
     *     @OA\Response(response="204", ref="#/components/responses/noContent"),
     *     @OA\Response(response="400", ref="#/components/responses/badRequest"),
     *     @OA\Response(response="500", ref="#/components/responses/generalError"),
     * ),
     * @param Request $request
     * @param UserResetPasswordConfirm $useCase
     * @param UserResetPasswordConfirmPresenterInterface $presenter
     * @return JsonResponse
     */
    #[Route('/reset-password-confirm', name: 'reset-password', methods: ['POST'])]
    public function resetPasswordConfirm(
        Request $request,
        UserResetPasswordConfirm $useCase,
        UserResetPasswordConfirmPresenterInterface $presenter
    ): JsonResponse
    {
        $content = json_decode($request->getContent(), true);
        $email = (string)($content[RequestFieldMapper::EMAIL] ?? '');
        $code = (string)($content[RequestFieldMapper::CODE] ?? '');
        $newPassword = (string)($content[RequestFieldMapper::NEW_PASSWORD] ?? '');

        $input = new UserResetPasswordConfirmRequest($email, $code, $newPassword);
        $useCase->execute($input, $presenter);
        return $presenter->view();
    }
}
