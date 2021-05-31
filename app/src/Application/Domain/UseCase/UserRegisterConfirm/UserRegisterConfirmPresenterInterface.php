<?php
declare(strict_types=1);
namespace App\Application\Domain\UseCase\UserRegisterConfirm;

/**
 * Interface UserRegisterConfirmPresenterInterface
 * @package App\Application\Domain\UseCase\UserRegisterConfirm
 */
interface UserRegisterConfirmPresenterInterface
{
    /**
     * @param UserRegisterConfirmResponse $response
     */
    public function present(UserRegisterConfirmResponse $response): void;

    /**
     * @return mixed
     */
    public function view();
}
