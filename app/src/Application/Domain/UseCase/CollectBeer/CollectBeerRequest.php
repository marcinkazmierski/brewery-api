<?php
declare(strict_types=1);
namespace App\Application\Domain\UseCase\CollectBeer;

use App\Application\Domain\Entity\User;

/**
 * Class CollectBeerRequest
 * @package App\Application\Domain\UseCase\CollectBeer
 */
class CollectBeerRequest
{
    /** @var User */
    private User $user;

    private string $beerCode;

    /**
     * CollectBeerRequest constructor.
     * @param User $user
     * @param string $beerCode
     */
    public function __construct(User $user, string $beerCode)
    {
        $this->user = $user;
        $this->beerCode = $beerCode;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getBeerCode(): string
    {
        return $this->beerCode;
    }

}
