<?php
declare(strict_types=1);

namespace App\Controller\Authentication;


use App\Application\Infrastructure\Repository\UserRepository;
use App\Application\Infrastructure\Repository\UserTokenRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/api/auth")
 *
 * Class AuthenticationController
 * @package App\Controller\Authentication
 */
class AuthenticationController extends AbstractController
{
    /** @var UserRepository */
    private $userRepository;

    /** @var UserTokenRepository */
    private $userTokenRepository;

    /**
     * AuthenticationController constructor.
     * @param UserRepository $userRepository
     * @param UserTokenRepository $userTokenRepository
     */
    public function __construct(UserRepository $userRepository, UserTokenRepository $userTokenRepository)
    {
        $this->userRepository = $userRepository;
        $this->userTokenRepository = $userTokenRepository;
    }

    /**
     * User authentication
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
        Request $request
    ): JsonResponse
    {
        $content = json_decode($request->getContent(), true);
        $email = (string)($content['email'] ?? '');
        $password = (string)($content['password'] ?? '');
        $user = $this->userRepository->getUserByEmailAndPassword($email, $password);
        $token = $this->userTokenRepository->generateToken($user);
        $responseData = ['authenticate' => 'OK', 'userId' => $user->getId(), 'token' => $token->getTokenKey()];
        return new JsonResponse($responseData, JsonResponse::HTTP_OK);
    }
}
