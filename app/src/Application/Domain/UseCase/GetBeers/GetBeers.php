<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\GetBeers;

use App\Application\Domain\Common\Factory\ErrorResponseFactory\ErrorResponseFromExceptionFactoryInterface;
use App\Application\Domain\Repository\BeerRepositoryInterface;

/**
 * Class GetBeers
 * @package App\Application\Domain\UseCase\GetBeers
 */
class GetBeers
{
    private BeerRepositoryInterface $beerRepository;

    private ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory;

    /**
     * GetBeers constructor.
     * @param BeerRepositoryInterface $beerRepository
     * @param ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory
     */
    public function __construct(BeerRepositoryInterface $beerRepository, ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory)
    {
        $this->beerRepository = $beerRepository;
        $this->errorResponseFromExceptionFactory = $errorResponseFromExceptionFactory;
    }


    /**
     * @param GetBeersRequest $request
     * @param GetBeersPresenterInterface $presenter
     */
    public function execute(
        GetBeersRequest            $request,
        GetBeersPresenterInterface $presenter)
    {
        $response = new GetBeersResponse();
        try {
            $beers = $this->beerRepository->findBy(['status' => 1]);
            $response->setOwner($request->getUser());
            $response->setAllBeers($beers);
            $response->setUnlockedBeers($request->getUser()->getUnlockedBeers());
        } catch (\Throwable $e) {
            $error = $this->errorResponseFromExceptionFactory->create($e);
            $response->setError($error);
        }
        $presenter->present($response);
    }
}
