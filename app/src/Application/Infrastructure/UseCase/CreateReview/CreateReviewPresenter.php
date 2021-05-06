<?php
declare(strict_types=1);
namespace App\Application\Infrastructure\UseCase\CreateReview;

use App\Application\Domain\UseCase\CreateReview\CreateReviewPresenterInterface;
use App\Application\Domain\UseCase\CreateReview\CreateReviewResponse;
use App\Application\Infrastructure\Common\AbstractPresenter;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class CreateReviewPresenter
 * @package App\Application\Infrastructure\UseCase\CreateReview
 */
class CreateReviewPresenter extends AbstractPresenter implements CreateReviewPresenterInterface
{
    /**
     * @var CreateReviewResponse $response
     */
    private $response;

    /**
     * @param CreateReviewResponse $response
     */
    public function present(CreateReviewResponse $response): void
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
        
        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
