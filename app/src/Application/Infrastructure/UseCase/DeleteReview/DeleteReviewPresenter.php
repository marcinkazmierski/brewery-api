<?php
declare(strict_types=1);
namespace App\Application\Infrastructure\UseCase\DeleteReview;

use App\Application\Domain\UseCase\DeleteReview\DeleteReviewPresenterInterface;
use App\Application\Domain\UseCase\DeleteReview\DeleteReviewResponse;
use App\Application\Infrastructure\Common\AbstractPresenter;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class DeleteReviewPresenter
 * @package App\Application\Infrastructure\UseCase\DeleteReview
 */
class DeleteReviewPresenter extends AbstractPresenter implements DeleteReviewPresenterInterface
{
    /**
     * @var DeleteReviewResponse $response
     */
    private $response;

    /**
     * @param DeleteReviewResponse $response
     */
    public function present(DeleteReviewResponse $response): void
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
