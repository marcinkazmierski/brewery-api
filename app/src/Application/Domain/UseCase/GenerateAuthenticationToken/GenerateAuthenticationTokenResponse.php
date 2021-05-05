<?php
declare(strict_types=1);
namespace App\Application\Domain\UseCase\GenerateAuthenticationToken;

use App\Application\Domain\Common\Response\AbstractResponse;
use App\Application\Domain\Entity\User;

/**
 * Class GenerateAuthenticationTokenResponse
 * @package App\Application\Domain\UseCase\GenerateAuthenticationToken
 */
class GenerateAuthenticationTokenResponse extends AbstractResponse
{
    /**
     * @var string
     */
    protected $tokenKey;

    /**
     * @var User
     */
    protected $user;

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
