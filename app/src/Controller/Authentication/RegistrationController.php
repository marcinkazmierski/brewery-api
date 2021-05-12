<?php
declare(strict_types=1);

namespace App\Controller\Authentication;

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
        Request $request
    ): JsonResponse
    {
        $content = json_decode($request->getContent(), true);
        // TODO
        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }

    /**
     * Activate user account
     * @param string $hash
     * @return JsonResponse
     */
    #[Route('/confirm/{hash}', name: 'confirm-user-account', methods: ['PUT'])]
    public function confirm(
        string $hash
    ): JsonResponse
    {
        // TODO
        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
