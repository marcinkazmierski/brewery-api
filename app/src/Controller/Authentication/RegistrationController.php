<?php
declare(strict_types=1);

namespace App\Controller\Authentication;

use App\Application\Domain\Common\Mapper\RequestFieldMapper;
use App\Application\Domain\Entity\User;
use App\Application\Domain\UseCase\UserRegister\UserRegister;
use App\Application\Domain\UseCase\UserRegister\UserRegisterPresenterInterface;
use App\Application\Domain\UseCase\UserRegister\UserRegisterRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

/**
 * Class RegistrationController
 * @package App\Controller\Authentication
 */
#[Route('/api/register')]
class RegistrationController extends AbstractController
{
    /**
     * Register user account.
     * @OA\Post(
     *     path="/api/register",
     *     description="Register user account.",
     *     tags = {"User"},
     *     @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          type = "object",
     *          @OA\Property(property="nick", ref="#/components/schemas/text"),
     *          @OA\Property(property="email", ref="#/components/schemas/email"),
     *          @OA\Property(property="password", ref="#/components/schemas/password"),
     *      ),
     *     ),
     *     @OA\Response(response="201", ref="#/components/responses/noContent"),
     *     @OA\Response(response="400", ref="#/components/responses/badRequest"),
     *     @OA\Response(response="500", ref="#/components/responses/generalError"),
     * ),
     * @param Request $request
     * @param UserRegister $useCase
     * @param UserRegisterPresenterInterface $presenter
     * @return JsonResponse
     */
    #[Route('', name: 'register-new-user', methods: ['POST'])]
    public function register(
        Request $request, UserRegister $useCase, UserRegisterPresenterInterface $presenter
    ): JsonResponse
    {
        $content = json_decode($request->getContent(), true);

        $nick = (string)($content[RequestFieldMapper::USER_NICK] ?? '');
        $email = mb_strtolower(trim((string)($content[RequestFieldMapper::EMAIL] ?? '')));
        $password = (string)($content[RequestFieldMapper::PASSWORD] ?? '');

        $input = new UserRegisterRequest($nick, $email, $password, null);
        $useCase->execute($input, $presenter);
        return $presenter->view();
    }

    // @todo swagger
    #[Route('/guest', name: 'register-guest', methods: ['POST'])]
    public function registerGuest(
        Request $request, UserRegister $useCase, UserRegisterPresenterInterface $presenter
    ): JsonResponse
    {
        $content = json_decode($request->getContent(), true);

        $nick = (string)($content[RequestFieldMapper::USER_NICK] ?? '');
        $email = mb_strtolower(trim((string)($content[RequestFieldMapper::EMAIL] ?? '')));
        $password = (string)($content[RequestFieldMapper::PASSWORD] ?? '');

        /** @var ?User $currentUser */
        $currentUser = $this->getUser();

        $input = new UserRegisterRequest($nick, $email, $password, $currentUser);
        $useCase->execute($input, $presenter);
        return $presenter->view();
    }

    /**
     * Activate user account
     * @param string $hash
     * @return JsonResponse
     */
    #[Route('/confirm/{hash}', name: 'confirm-user-account-api', methods: ['PUT'])]
    public function confirm(
        string $hash
    ): JsonResponse
    {
        // TODO: @see: FrontController::confirm
        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
