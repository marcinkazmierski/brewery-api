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
