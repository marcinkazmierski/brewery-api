<?php

namespace App\Controller\Beer;

use App\Application\Domain\Entity\User;
use App\Application\Domain\UseCase\GetBeers\GetBeers;
use App\Application\Domain\UseCase\GetBeers\GetBeersPresenterInterface;
use App\Application\Domain\UseCase\GetBeers\GetBeersRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;


#[Route('/api/beers')]
class BeerController extends AbstractController
{
    /**
     * Get list of beers.
     * @OA\Get(
     *     path="/api/beers",
     *     description="Get list of beers.",
     *     tags = {"Beer"},
     *     @OA\Parameter(ref="#/components/parameters/X-AUTH-TOKEN"),
     *     @OA\Response(
     *          response="200",
     *          description="Array of beers",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="unlockedBeers", type="array", @OA\Items(ref="#/components/schemas/Beer")),
     *              @OA\Property(property="allBeers", type="array", @OA\Items(ref="#/components/schemas/Beer")),
     *          ),
     *     ),
     *     @OA\Response(response="400", ref="#/components/responses/badRequest"),
     *     @OA\Response(response="500", ref="#/components/responses/generalError"),
     * ),
     * @param GetBeers $useCase
     * @param GetBeersPresenterInterface $presenter
     * @return Response
     */
    #[Route('', name: 'beer-list', methods: ['GET'])]
    public function list(  GetBeers $useCase, GetBeersPresenterInterface $presenter): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();

        $authenticationRequest = new GetBeersRequest($currentUser);
        $useCase->execute($authenticationRequest, $presenter);
        return $presenter->view();
    }
}
