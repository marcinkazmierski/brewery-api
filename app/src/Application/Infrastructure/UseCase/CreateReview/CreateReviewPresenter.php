<?php
declare(strict_types=1);

namespace App\Application\Infrastructure\UseCase\CreateReview;

use App\Application\Domain\Common\Factory\EntityResponseFactory\BeerResponseFactory;
use App\Application\Domain\Common\Mapper\ResponseFieldMapper;
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
    /** @var BeerResponseFactory */
    protected BeerResponseFactory $beerResponseFactory;

    /**
     * @var CreateReviewResponse $response
     */
    private $response;


    /**
     * GetBeersPresenter constructor.
     * @param BeerResponseFactory $beerResponseFactory
     */
    public function __construct(BeerResponseFactory $beerResponseFactory)
    {
        $this->beerResponseFactory = $beerResponseFactory;
    }

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

        $data = [
            ResponseFieldMapper::REVIEW_ID => $this->response->getReview()->getId(),
            ResponseFieldMapper::BEER => $this->beerResponseFactory->create($this->response->getReview()->getBeer()),
        ];
        return new JsonResponse($data, JsonResponse::HTTP_OK);
    }
}
