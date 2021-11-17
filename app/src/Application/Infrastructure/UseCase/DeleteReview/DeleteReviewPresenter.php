<?php
declare(strict_types=1);

namespace App\Application\Infrastructure\UseCase\DeleteReview;

use App\Application\Domain\Common\Factory\EntityResponseFactory\BeerResponseFactory;
use App\Application\Domain\Common\Mapper\ResponseFieldMapper;
use App\Application\Domain\UseCase\DeleteReview\DeleteReviewPresenterInterface;
use App\Application\Domain\UseCase\DeleteReview\DeleteReviewResponse;
use App\Application\Infrastructure\Common\AbstractPresenter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DeleteReviewPresenter
 * @package App\Application\Infrastructure\UseCase\DeleteReview
 */
class DeleteReviewPresenter extends AbstractPresenter implements DeleteReviewPresenterInterface
{
    /** @var BeerResponseFactory */
    protected BeerResponseFactory $beerResponseFactory;

    /**
     * @var DeleteReviewResponse $response
     */
    private DeleteReviewResponse $response;

    /**
     * DeleteReviewPresenter constructor.
     * @param BeerResponseFactory $beerResponseFactory
     */
    public function __construct(BeerResponseFactory $beerResponseFactory)
    {
        $this->beerResponseFactory = $beerResponseFactory;
    }

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
            $statusCode = Response::HTTP_BAD_REQUEST;
            return $this->viewErrorResponse($this->response->getError(), $statusCode);
        }

        $data = [
            ResponseFieldMapper::BEER => $this->beerResponseFactory->create($this->response->getBeer(), $this->response->getOwner()),
        ];
        return new JsonResponse($data, Response::HTTP_OK);
    }
}
