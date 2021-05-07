<?php
declare(strict_types=1);
namespace App\Application\Domain\UseCase\GetBeers;

/**
 * Interface GetBeersPresenterInterface
 * @package App\Application\Domain\UseCase\GetBeers
 */
interface GetBeersPresenterInterface
{
    /**
     * @param GetBeersResponse $response
     */
    public function present(GetBeersResponse $response): void;

    /**
     * @return mixed
     */
    public function view();
}
