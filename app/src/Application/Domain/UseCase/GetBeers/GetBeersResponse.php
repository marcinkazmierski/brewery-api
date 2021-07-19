<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\GetBeers;

use App\Application\Domain\Common\Response\AbstractResponse;
use App\Application\Domain\Entity\Beer;
use Doctrine\Common\Collections\Collection;

/**
 * Class GetBeersResponse
 * @package App\Application\Domain\UseCase\GetBeers
 */
class GetBeersResponse extends AbstractResponse
{
    /** @var Beer[] */
    private Collection $unlockedBeers;

    /** @var Beer[] */
    private array $allBeers;

    /**
     * @return Beer[]
     */
    public function getUnlockedBeers(): Collection
    {
        return $this->unlockedBeers;
    }

    /**
     * @param Beer[] $unlockedBeers
     */
    public function setUnlockedBeers(Collection $unlockedBeers): void
    {
        $this->unlockedBeers = $unlockedBeers;
    }

    /**
     * @return Beer[]
     */
    public function getAllBeers(): array
    {
        return $this->allBeers;
    }

    /**
     * @param Beer[] $allBeers
     */
    public function setAllBeers(array $allBeers): void
    {
        $this->allBeers = $allBeers;
    }


}
