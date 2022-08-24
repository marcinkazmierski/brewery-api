<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\StoreNotificationToken;

use App\Application\Domain\Entity\User;

/**
 * Class StoreNotificationTokenRequest
 * @package App\Application\Domain\UseCase\StoreNotificationToken
 */
class StoreNotificationTokenRequest
{
    /** @var string */
    private string $token;

    /** @var User */
    private User $user;

    /**
     * @param string $token
     * @param User $user
     */
    public function __construct(string $token, User $user)
    {
        $this->token = $token;
        $this->user = $user;
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
    public function getToken(): string
    {
        return $this->token;
    }
}
