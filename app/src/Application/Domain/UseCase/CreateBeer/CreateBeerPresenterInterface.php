<?php
declare(strict_types=1);
namespace App\Application\Domain\UseCase\CreateBeer;

/**
 * Interface CreateBeerPresenterInterface
 * @package App\Application\Domain\UseCase\CreateBeer
 */
interface CreateBeerPresenterInterface
{
    /**
     * @param CreateBeerResponse $response
     */
    public function present(CreateBeerResponse $response): void;

    /**
     * @return mixed
     */
    public function view();
}
