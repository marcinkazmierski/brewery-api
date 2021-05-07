<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\GetBeers;

use App\Application\Domain\Entity\User;

/**
 * Class GetBeersRequest
 * @package App\Application\Domain\UseCase\GetBeers
 */
class GetBeersRequest
{
    /** @var User */
    private User $user;

    /**
     * GetBeersRequest constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}
