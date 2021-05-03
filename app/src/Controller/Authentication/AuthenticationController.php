<?php
declare(strict_types=1);

namespace App\Controller\Authentication;


use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/api/v1/auth")
 *
 * Class AuthenticationController
 * @package App\Controller\Authentication
 */
class AuthenticationController extends AbstractController
{
    /** @var UserRepository */
    private $userRepository;

    /**
     * AuthenticationController constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
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
     */
    public function authenticate(
        Request $request
    ): JsonResponse
    {
        $content = json_decode($request->getContent(), true);
        $email = (string)($content['email'] ?? '');
        $password = (string)($content['password'] ?? '');
        $user = $this->userRepository->getUserByEmailAndPassword($email, $password);

        $responseData = ['authenticate' => 'OK', 'userId' => $user->getId()];
        return new JsonResponse($responseData, JsonResponse::HTTP_OK);
    }
}
