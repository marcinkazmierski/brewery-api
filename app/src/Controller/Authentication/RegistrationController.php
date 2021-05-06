<?php
declare(strict_types=1);

namespace App\Controller\Authentication;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RegistrationController
 * @package App\Controller\Authentication
 *
 * @Route("/api/register")
 */
class RegistrationController
{
    /**
     * Register user account.
     * @Route(
     *     "",
     *     methods={"POST"},
     *     name="register-new-user"
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
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
     * @Route(
     *     "/confirm/{hash}",
     *     methods={"PUT"},
     *     name="confirm-user-account"
     * )
     * @param string $hash
     * @return JsonResponse
     */
    public function confirm(
        string $hash
    ): JsonResponse
    {
        // TODO
        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
