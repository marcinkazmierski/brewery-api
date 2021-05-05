<?php
declare(strict_types=1);

namespace App\Controller\Authentication;


use App\Application\Domain\Common\Mapper\RequestFieldMapper;
use App\Application\Domain\UseCase\GenerateAuthenticationToken\GenerateAuthenticationToken;
use App\Application\Domain\UseCase\GenerateAuthenticationToken\GenerateAuthenticationTokenPresenterInterface;
use App\Application\Domain\UseCase\GenerateAuthenticationToken\GenerateAuthenticationTokenRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

/**
 * @Route("/api/auth")
 *
 * Class AuthenticationController
 * @package App\Controller\Authentication
 */
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
     *          @OA\Property(property="userId", description="User ID", ref="#/components/schemas/userId")
     *      )
     *     ),
     *     @OA\Response(response="400", ref="#/components/responses/badRequest"),
     *     @OA\Response(response="500", ref="#/components/responses/generalError"),
     * ),
     *
     * @Route(
     *     "/authenticate",
     *     methods={"POST"},
     *     name="authenticate"
     * )
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
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
}
