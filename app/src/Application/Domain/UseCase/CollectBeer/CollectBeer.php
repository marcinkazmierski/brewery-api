<?php
declare(strict_types=1);
namespace App\Application\Domain\UseCase\CollectBeer;

use App\Application\Domain\Common\Factory\ErrorResponseFactory\ErrorResponseFromExceptionFactoryInterface;

/**
 * Class CollectBeer
 * @package App\Application\Domain\UseCase\CollectBeer
 */
class CollectBeer
{
    /** @var ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory */
    private $errorResponseFromExceptionFactory;

    /**
     * CollectBeer constructor.
     * @param ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory
     */
    public function __construct
    (
        ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory
    )
    {
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
            //TODO
        } catch (\Throwable $e) {
            $error = $this->errorResponseFromExceptionFactory->create($e);
            $response->setError($error);
        }
        $presenter->present($response);
    }
}
