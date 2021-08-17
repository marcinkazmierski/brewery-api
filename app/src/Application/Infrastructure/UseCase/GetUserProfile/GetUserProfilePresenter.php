<?php
declare(strict_types=1);

namespace App\Application\Infrastructure\UseCase\GetUserProfile;

use App\Application\Domain\Common\Factory\EntityResponseFactory\UserResponseFactory;
use App\Application\Domain\Common\Mapper\ResponseFieldMapper;
use App\Application\Domain\UseCase\GetUserProfile\GetUserProfilePresenterInterface;
use App\Application\Domain\UseCase\GetUserProfile\GetUserProfileResponse;
use App\Application\Infrastructure\Common\AbstractPresenter;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class GetUserProfilePresenter
 * @package App\Application\Infrastructure\UseCase\GetUserProfile
 */
class GetUserProfilePresenter extends AbstractPresenter implements GetUserProfilePresenterInterface
{
    protected UserResponseFactory $userResponseFactory;

    /**
     * @var GetUserProfileResponse $response
     */
    private $response;

    /**
     * @param UserResponseFactory $userResponseFactory
     */
    public function __construct(UserResponseFactory $userResponseFactory)
    {
        $this->userResponseFactory = $userResponseFactory;
    }

    /**
     * @param GetUserProfileResponse $response
     */
    public function present(GetUserProfileResponse $response): void
    {
        $this->response = $response;
    }

    /**
     * @return JsonResponse
     */
    public function view()
    {
        if ($this->response->hasError()) {
            $statusCode = JsonResponse::HTTP_BAD_REQUEST;
            return $this->viewErrorResponse($this->response->getError(), $statusCode);
        }

        return new JsonResponse($this->userResponseFactory->create($this->response->getUser()), JsonResponse::HTTP_OK);
    }
}
