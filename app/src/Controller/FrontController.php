<?php
declare(strict_types=1);

namespace App\Controller;

use App\Application\Domain\UseCase\UserRegisterConfirm\UserRegisterConfirm;
use App\Application\Domain\UseCase\UserRegisterConfirm\UserRegisterConfirmPresenterInterface;
use App\Application\Domain\UseCase\UserRegisterConfirm\UserRegisterConfirmRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
class FrontController extends AbstractController
{
    /**
     * @return Response
     */
    #[Route('', name: 'index')]
    public function index(): Response
    {
        return $this->render("front/index.html.twig", []);
    }

    /**
     * Activate user account.
     * @param string $hash
     * @param UserRegisterConfirm $useCase
     * @param UserRegisterConfirmPresenterInterface $presenter
     * @return Response
     */
    #[Route('/confirm/{hash}', name: 'confirm-user-account', methods: ['GET'])]
    public function confirm(
        string $hash,
        UserRegisterConfirm $useCase, UserRegisterConfirmPresenterInterface $presenter
    ): Response
    {
        $input = new UserRegisterConfirmRequest($hash);
        $useCase->execute($input, $presenter);
        return $presenter->view();
    }
}
