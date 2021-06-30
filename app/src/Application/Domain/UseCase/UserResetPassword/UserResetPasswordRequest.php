<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\UserResetPassword;

/**
 * Class UserResetPasswordRequest
 * @package App\Application\Domain\UseCase\UserResetPassword
 */
class UserResetPasswordRequest
{
    /**
     * @var string
     */
    private string $email;

    /**
     * UserResetPasswordRequest constructor.
     * @param string $email
     */
    public function __construct(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
}
