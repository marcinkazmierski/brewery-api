<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\GenerateAuthenticationGuestToken;

use App\Application\Domain\Common\Response\AbstractResponse;
use App\Application\Domain\Entity\User;

/**
 * Class GenerateAuthenticationGuestTokenResponse
 * @package App\Application\Domain\UseCase\GenerateAuthenticationGuestToken
 */
class GenerateAuthenticationGuestTokenResponse extends AbstractResponse
{
    /**
     * @var string
     */
    protected string $tokenKey;

    /**
     * @var User
     */
    protected User $user;

    /**
     * @return string
     */
    public function getTokenKey(): string
    {
        return $this->tokenKey;
    }

    /**
     * @param string $tokenKey
     */
    public function setTokenKey(string $tokenKey): void
    {
        $this->tokenKey = $tokenKey;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }
}
