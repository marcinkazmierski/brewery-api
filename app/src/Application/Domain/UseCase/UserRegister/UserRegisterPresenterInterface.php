<?php
declare(strict_types=1);
namespace App\Application\Domain\UseCase\UserRegister;

/**
 * Interface UserRegisterPresenterInterface
 * @package App\Application\Domain\UseCase\UserRegister
 */
interface UserRegisterPresenterInterface
{
    /**
     * @param UserRegisterResponse $response
     */
    public function present(UserRegisterResponse $response): void;

    /**
     * @return mixed
     */
    public function view();
}
