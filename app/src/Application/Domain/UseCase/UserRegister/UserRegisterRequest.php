<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\UserRegister;

/**
 * Class UserRegisterRequest
 * @package App\Application\Domain\UseCase\UserRegister
 */
class UserRegisterRequest
{
    private string $nick;
    private string $email;

    /**
     * UserRegisterRequest constructor.
     * @param string $nick
     * @param string $email
     */
    public function __construct(string $nick, string $email)
    {
        $this->nick = $nick;
        $this->email = $email;
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

}
