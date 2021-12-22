<?php
declare(strict_types=1);

namespace App\Application\Infrastructure\UseCase\GetBeers;

use App\Application\Domain\Common\Constants\UserBeerStatusConstants;
use App\Application\Domain\Common\Factory\EntityResponseFactory\BeerResponseFactory;
use App\Application\Domain\Common\Mapper\ResponseFieldMapper;
use App\Application\Domain\UseCase\GetBeers\GetBeersPresenterInterface;
use App\Application\Domain\UseCase\GetBeers\GetBeersResponse;
use App\Application\Infrastructure\Common\AbstractPresenter;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class GetBeersPresenter
 * @package App\Application\Infrastructure\UseCase\GetBeers
 */
class GetBeersPresenter extends AbstractPresenter implements GetBeersPresenterInterface
{
    /** @var BeerResponseFactory */
    protected BeerResponseFactory $beerResponseFactory;
    /**
     * @var GetBeersResponse $response
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
     * @param GetBeersResponse $response
     */
    public function present(GetBeersResponse $response): void
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

        $beers = [];
        foreach ($this->response->getAllBeers() as $beer) {
            $beers[] = $this->beerResponseFactory->create($beer, $this->response->getOwner());
        }

        $data = [
            ResponseFieldMapper::BEERS => $beers,
        ];
        return new JsonResponse($data, JsonResponse::HTTP_OK);
    }
}
