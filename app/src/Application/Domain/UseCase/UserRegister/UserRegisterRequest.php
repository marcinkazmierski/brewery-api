<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\UserRegister;

use App\Application\Domain\Entity\User;

/**
 * Class UserRegisterRequest
 * @package App\Application\Domain\UseCase\UserRegister
 */
class UserRegisterRequest
{
    private string $nick;
    private string $email;
    private string $password;
    private ?User  $user;

    /**
     * @param string $nick
     * @param string $email
     * @param string $password
     * @param User|null $user
     */
    public function __construct(string $nick, string $email, string $password, ?User $user)
    {
        $this->nick = $nick;
        $this->email = $email;
        $this->password = $password;
        $this->user = $user;
    }


    /**
     * @return string
     */
    public function getNick(): string
    {
        return $this->nick;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }
}
