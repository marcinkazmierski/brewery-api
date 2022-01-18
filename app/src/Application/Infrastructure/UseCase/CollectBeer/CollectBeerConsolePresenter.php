<?php
declare(strict_types=1);

namespace App\Application\Infrastructure\UseCase\CollectBeer;

use App\Application\Domain\UseCase\CollectBeer\CollectBeerPresenterInterface;
use App\Application\Domain\UseCase\CollectBeer\CollectBeerResponse;

/**
 * Class CollectBeerConsolePresenter
 * @package App\Application\Infrastructure\UseCase\CollectBeer
 */
class CollectBeerConsolePresenter implements CollectBeerPresenterInterface
{
    /**
     * @var CollectBeerResponse $response
     */
    private $response;

    /**
     * @param CollectBeerResponse $response
     */
    public function present(CollectBeerResponse $response): void
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
