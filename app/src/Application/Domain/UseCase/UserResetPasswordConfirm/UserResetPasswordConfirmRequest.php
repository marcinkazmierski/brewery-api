<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\UserResetPasswordConfirm;

/**
 * Class UserResetPasswordConfirmRequest
 * @package App\Application\Domain\UseCase\UserResetPasswordConfirm
 */
class UserResetPasswordConfirmRequest
{
    /**
     * @var string
     */
    private string $email;

    /**
     * @var string
     */
    private string $hash;

    /**
     * @var string
     */
    private string $newPassword;

    /**
     * UserResetPasswordConfirmRequest constructor.
     * @param string $email
     * @param string $hash
     * @param string $newPassword
     */
    public function __construct(string $email, string $hash, string $newPassword)
    {
        $this->email = $email;
        $this->hash = $hash;
        $this->newPassword = $newPassword;
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
    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * @return string
     */
    public function getNewPassword(): string
    {
        return $this->newPassword;
    }
}
