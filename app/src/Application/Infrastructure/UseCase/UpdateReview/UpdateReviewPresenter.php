<?php
declare(strict_types=1);
namespace App\Application\Infrastructure\UseCase\UpdateReview;

use App\Application\Domain\UseCase\UpdateReview\UpdateReviewPresenterInterface;
use App\Application\Domain\UseCase\UpdateReview\UpdateReviewResponse;
use App\Application\Infrastructure\Common\AbstractPresenter;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class UpdateReviewPresenter
 * @package App\Application\Infrastructure\UseCase\UpdateReview
 */
class UpdateReviewPresenter extends AbstractPresenter implements UpdateReviewPresenterInterface
{
    /**
     * @var UpdateReviewResponse $response
     */
    private $response;

    /**
     * @param UpdateReviewResponse $response
     */
    public function present(UpdateReviewResponse $response): void
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
