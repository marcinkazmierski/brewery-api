<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\CreateBeer;

use App\Application\Domain\Common\Factory\ErrorResponseFactory\ErrorResponseFromExceptionFactoryInterface;
use App\Application\Domain\Entity\Beer;
use App\Application\Domain\Exception\ValidateException;
use App\Application\Domain\Repository\BeerRepositoryInterface;

/**
 * Class CreateBeer
 * @package App\Application\Domain\UseCase\CreateBeer
 */
class CreateBeer
{
    /** @var BeerRepositoryInterface */
    private BeerRepositoryInterface $beerRepository;

    /** @var ErrorResponseFromExceptionFactoryInterface */
    private ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory;

    /**
     * @param BeerRepositoryInterface $beerRepository
     * @param ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory
     */
    public function __construct(BeerRepositoryInterface $beerRepository, ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory)
    {
        $this->beerRepository = $beerRepository;
        $this->errorResponseFromExceptionFactory = $errorResponseFromExceptionFactory;
    }


    /**
     * @param CreateBeerRequest $request
     * @param CreateBeerPresenterInterface $presenter
     */
    public function execute(
        CreateBeerRequest            $request,
        CreateBeerPresenterInterface $presenter)
    {
        $response = new CreateBeerResponse();
        try {
            if (empty($request->getName())) {
                throw new ValidateException("Empty name field");
            }
            if (empty($request->getTitle())) {
                throw new ValidateException("Empty title field");
            }
            if (empty($request->getDescription())) {
                throw new ValidateException("Empty description field");
            }
            if (empty($request->getCode()) || strlen($request->getCode()) < 5) {
                throw new ValidateException("Empty or too short (min 5 chars) code field");
            }
            if ($this->beerRepository->findOneBy(['code' => $request->getCode()])) {
                throw new ValidateException("Beer already exist with this code");
            }
            if (empty($request->getIcon()) || !@getimagesize($request->getIcon())) {
                throw new ValidateException("Empty or invalid icon field");
            }
            if (empty($request->getTags())) {
                throw new ValidateException("Empty tags field");
            }
            if (empty($request->getBackgroundImage()) || !@getimagesize($request->getBackgroundImage())) {
                throw new ValidateException("Empty or invalid backgroundImage field");
            }
            if (empty($request->getHops())) {
                throw new ValidateException("Empty hops field");
            }
            if (empty($request->getMalts())) {
                throw new ValidateException("Empty malts field");
            }

            $beer = new Beer();
            $beer->setName($request->getName());
            $beer->setBackgroundImage($request->getBackgroundImage());
            $beer->setDescription($request->getDescription());
            $beer->setTitle($request->getTitle());
            $beer->setTags($request->getTags());
            $beer->setStatus($request->isStatus());
            $beer->setCode($request->getCode());
            $beer->setIcon($request->getIcon());
            $beer->setHops($request->getHops());
            $beer->setMalts($request->getMalts());
            $this->beerRepository->save($beer);
        } catch (\Throwable $e) {
            $error = $this->errorResponseFromExceptionFactory->create($e);
            $response->setError($error);
        }
        $presenter->present($response);
    }
}
