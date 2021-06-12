<?php
declare(strict_types=1);
namespace App\Application\Domain\UseCase\UserResetPassword;

/**
 * Interface UserResetPasswordPresenterInterface
 * @package App\Application\Domain\UseCase\UserResetPassword
 */
interface UserResetPasswordPresenterInterface
{
    /**
     * @param UserResetPasswordResponse $response
     */
    public function present(UserResetPasswordResponse $response): void;

    /**
     * @return mixed
     */
    public function view();
}
