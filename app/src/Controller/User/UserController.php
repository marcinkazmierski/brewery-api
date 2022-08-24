<?php

namespace App\Controller\User;

use App\Application\Domain\Common\Mapper\RequestFieldMapper;
use App\Application\Domain\Entity\User;

use App\Application\Domain\UseCase\GetUserProfile\GetUserProfile;
use App\Application\Domain\UseCase\GetUserProfile\GetUserProfilePresenterInterface;
use App\Application\Domain\UseCase\GetUserProfile\GetUserProfileRequest;
use App\Application\Domain\UseCase\StoreNotificationToken\StoreNotificationToken;
use App\Application\Domain\UseCase\StoreNotificationToken\StoreNotificationTokenPresenterInterface;
use App\Application\Domain\UseCase\StoreNotificationToken\StoreNotificationTokenRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

#[Route('/api/user')]
class UserController extends AbstractController
{
    /**
     * User profile.
     * @OA\Get(
     *     path="/api/user",
     *     description="Get user profile.",
     *     tags = {"User"},
     *     @OA\Parameter(ref="#/components/parameters/X-AUTH-TOKEN"),
     *     @OA\Response(
     *          response="200",
     *          description="User profile",
     *          @OA\JsonContent(
     *              type="object",
     *              ref="#/components/schemas/User",
     *          ),
     *     ),
     *     @OA\Response(response="400", ref="#/components/responses/badRequest"),
     *     @OA\Response(response="500", ref="#/components/responses/generalError"),
     * ),
     * @param GetUserProfile $useCase
     * @param GetUserProfilePresenterInterface $presenter
     * @return Response
     */
    #[Route('', name: 'user-profile', methods: ['GET'])]
    public function list(GetUserProfile $useCase, GetUserProfilePresenterInterface $presenter): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();

        $authenticationRequest = new GetUserProfileRequest($currentUser);
        $useCase->execute($authenticationRequest, $presenter);
        return $presenter->view();
    }
    //@todo: swagger
    #[Route('/store-notification-token', name: 'store-notification-token', methods: ['POST'])]
    public function storeNotificationToken(Request $request, StoreNotificationToken $useCase, StoreNotificationTokenPresenterInterface $presenter): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();

        $content = json_decode($request->getContent(), true);
        $token = (string)($content[RequestFieldMapper::NOTIFICATION_TOKEN] ?? '');

        $authenticationRequest = new StoreNotificationTokenRequest($token, $currentUser);
        $useCase->execute($authenticationRequest, $presenter);
        return $presenter->view();
    }
}
