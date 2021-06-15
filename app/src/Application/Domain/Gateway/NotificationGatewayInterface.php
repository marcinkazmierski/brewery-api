<?php
declare(strict_types=1);

namespace App\Application\Domain\Gateway;


use App\Application\Domain\Entity\User;
use App\Application\Domain\Exception\GatewayException;

interface NotificationGatewayInterface
{
    /**
     * @param User $user
     * @param string $confirmHash
     * @throws GatewayException
     */
    public function userRegister(User $user, string $confirmHash): void;

    /**
     * @param User $user
     * @param string $confirmHash
     * @throws GatewayException
     */
    public function userResetPassword(User $user, string $confirmHash): void;
}