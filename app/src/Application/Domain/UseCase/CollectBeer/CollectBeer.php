<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\CollectBeer;

use App\Application\Domain\Common\Factory\ErrorResponseFactory\ErrorResponseFromExceptionFactoryInterface;
use App\Application\Domain\Entity\Beer;
use App\Application\Domain\Exception\ValidateException;
use App\Application\Domain\Repository\BeerRepositoryInterface;
use App\Application\Domain\Repository\UserRepositoryInterface;

/**
 * Class CollectBeer
 * @package App\Application\Domain\UseCase\CollectBeer
 */
class CollectBeer
{
    private BeerRepositoryInterface $beerRepository;

    private UserRepositoryInterface $userRepository;

    private ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory;

    /**
     * CollectBeer constructor.
     * @param BeerRepositoryInterface $beerRepository
     * @param UserRepositoryInterface $userRepository
     * @param ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory
     */
    public function __construct(BeerRepositoryInterface $beerRepository, UserRepositoryInterface $userRepository, ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory)
    {
        $this->beerRepository = $beerRepository;
        $this->userRepository = $userRepository;
        $this->errorResponseFromExceptionFactory = $errorResponseFromExceptionFactory;
    }

    /**
     * @param CollectBeerRequest $request
     * @param CollectBeerPresenterInterface $presenter
     */
    public function execute(
        CollectBeerRequest $request,
        CollectBeerPresenterInterface $presenter)
    {
        $response = new CollectBeerResponse();
        try {
            if (empty($request->getBeerCode())) {
                throw new ValidateException("Empty beerCode field");
            }
            /** @var Beer $beer */
            $beer = $this->beerRepository->findOneBy(['code' => $request->getBeerCode()]);
            if (!$beer) {
                throw new ValidateException("Invalid beerCode value");
            }
            $user = $request->getUser();
            if ($user->getUnlockedBeers()->contains($beer)) {
                throw new ValidateException("Already contains");
            }

            $user->getUnlockedBeers()->add($beer);
            $this->userRepository->save($user);
        } catch (\Throwable $e) {
            $error = $this->errorResponseFromExceptionFactory->create($e);
            $response->setError($error);
        }
        $presenter->present($response);
    }
}
