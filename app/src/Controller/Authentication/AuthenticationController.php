<?php
declare(strict_types=1);

namespace App\Controller\Authentication;


use App\Application\Domain\Common\Mapper\RequestFieldMapper;
use App\Application\Domain\UseCase\GenerateAuthenticationToken\GenerateAuthenticationToken;
use App\Application\Domain\UseCase\GenerateAuthenticationToken\GenerateAuthenticationTokenPresenterInterface;
use App\Application\Domain\UseCase\GenerateAuthenticationToken\GenerateAuthenticationTokenRequest;
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
        Request $request,
        GenerateAuthenticationToken $authentication,
        GenerateAuthenticationTokenPresenterInterface $presenter
    ): JsonResponse
    {
        $content = json_decode($request->getContent(), true);
        $email = (string)($content[RequestFieldMapper::EMAIL] ?? '');
        $password = (string)($content[RequestFieldMapper::PASSWORD] ?? '');
        $appVersion = (string)($content[RequestFieldMapper::APP_VERSION] ?? '');

        $authenticationRequest = new GenerateAuthenticationTokenRequest($email, $password, $appVersion);
        $authentication->execute($authenticationRequest, $presenter);
        return $presenter->view();
    }
}
