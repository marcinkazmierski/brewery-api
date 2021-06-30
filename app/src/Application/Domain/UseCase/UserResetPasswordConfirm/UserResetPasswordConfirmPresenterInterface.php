<?php
declare(strict_types=1);
namespace App\Application\Domain\UseCase\UserResetPasswordConfirm;

/**
 * Interface UserResetPasswordConfirmPresenterInterface
 * @package App\Application\Domain\UseCase\UserResetPasswordConfirm
 */
interface UserResetPasswordConfirmPresenterInterface
{
    /**
     * @param UserResetPasswordConfirmResponse $response
     */
    public function present(UserResetPasswordConfirmResponse $response): void;

    /**
     * @return mixed
     */
    public function view();
}
