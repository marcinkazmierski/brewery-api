<?php
declare(strict_types=1);

namespace App\Application\Domain\Gateway;


use App\Application\Domain\Entity\User;
use App\Application\Domain\Exception\ValidateException;

interface NotificationGatewayInterface
{
    /**
     * @param User $user
     * @throws ValidateException
     */
    public function userRegister(User $user): void;
}