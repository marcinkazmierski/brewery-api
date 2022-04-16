<?php
declare(strict_types=1);
namespace App\Application\Infrastructure\UseCase\GenerateAuthenticationGuestToken;

use App\Application\Domain\Common\Mapper\ResponseFieldMapper;
use App\Application\Domain\UseCase\GenerateAuthenticationGuestToken\GenerateAuthenticationGuestTokenPresenterInterface;
use App\Application\Domain\UseCase\GenerateAuthenticationGuestToken\GenerateAuthenticationGuestTokenResponse;
use App\Application\Infrastructure\Common\AbstractPresenter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class GenerateAuthenticationGuestTokenPresenter
 * @package App\Application\Infrastructure\UseCase\GenerateAuthenticationGuestToken
 */
class GenerateAuthenticationGuestTokenPresenter extends AbstractPresenter implements GenerateAuthenticationGuestTokenPresenterInterface
{
    /**
     * @var GenerateAuthenticationGuestTokenResponse $response
     */
    private $response;

    /**
     * @param GenerateAuthenticationGuestTokenResponse $response
     */
    public function present(GenerateAuthenticationGuestTokenResponse $response): void
    {
        $this->response = $response;
    }

    /**
     * @return JsonResponse
     */
    public function view()
    {
        if ($this->response->hasError()) {
            $statusCode = Response::HTTP_BAD_REQUEST;
            return $this->viewErrorResponse($this->response->getError(), $statusCode);
        }

        $responseData = [
            ResponseFieldMapper::USER_TOKEN => $this->response->getTokenKey(),
            ResponseFieldMapper::USER_ID => $this->response->getUser()->getId(),
            ResponseFieldMapper::USER_NICK => $this->response->getUser()->getNick(),
        ];

        return new JsonResponse($responseData, Response::HTTP_OK);
    }
}
