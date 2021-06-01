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
    private string $password;

    /**
     * UserRegisterRequest constructor.
     * @param string $nick
     * @param string $email
     * @param string $password
     */
    public function __construct(string $nick, string $email, string $password)
    {
        $this->nick = $nick;
        $this->email = $email;
        $this->password = $password;
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
}
