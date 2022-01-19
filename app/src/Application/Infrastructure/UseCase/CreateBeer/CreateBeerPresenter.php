<?php
declare(strict_types=1);

namespace App\Application\Infrastructure\UseCase\CreateBeer;

use App\Application\Domain\UseCase\CreateBeer\CreateBeerPresenterInterface;
use App\Application\Domain\UseCase\CreateBeer\CreateBeerResponse;

/**
 * Class CreateBeerPresenter
 * @package App\Application\Infrastructure\UseCase\CreateBeer
 */
class CreateBeerPresenter implements CreateBeerPresenterInterface
{
    /**
     * @var CreateBeerResponse $response
     */
    private $response;

    /**
     * @param CreateBeerResponse $response
     */
    public function present(CreateBeerResponse $response): void
    {
        $this->response = $response;
    }

    /**
     * @return string
     */
    public function view()
    {
        if ($this->response->hasError()) {
            return $this->response->getError()->getMessage();
        }

        return print("Done!");
    }
}
