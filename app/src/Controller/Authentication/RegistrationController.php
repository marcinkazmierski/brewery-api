<?php
declare(strict_types=1);

namespace App\Controller\Authentication;

use App\Application\Domain\Common\Mapper\RequestFieldMapper;
use App\Application\Domain\UseCase\UserRegister\UserRegister;
use App\Application\Domain\UseCase\UserRegister\UserRegisterPresenterInterface;
use App\Application\Domain\UseCase\UserRegister\UserRegisterRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RegistrationController
 * @package App\Controller\Authentication
 */
#[Route('/api/register')]
class RegistrationController
{
    /**
     * Register user account.
     *
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('', name: 'register-new-user', methods: ['POST'])]
    public function register(
        Request $request, UserRegister $useCase, UserRegisterPresenterInterface $presenter
    ): JsonResponse
    {
        $content = json_decode($request->getContent(), true);
        $content = json_decode($request->getContent(), true);

        $nick = (string)($content[RequestFieldMapper::USER_NICK] ?? '');
        $email = (string)($content[RequestFieldMapper::EMAIL] ?? '');
        $input = new UserRegisterRequest($nick, $email);
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
        // TODO
        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
