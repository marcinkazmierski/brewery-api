<?php
declare(strict_types=1);
namespace App\Application\Domain\UseCase\CollectBeer;

/**
 * Interface CollectBeerPresenterInterface
 * @package App\Application\Domain\UseCase\CollectBeer
 */
interface CollectBeerPresenterInterface
{
    /**
     * @param CollectBeerResponse $response
     */
    public function present(CollectBeerResponse $response): void;

    /**
     * @return mixed
     */
    public function view();
}
