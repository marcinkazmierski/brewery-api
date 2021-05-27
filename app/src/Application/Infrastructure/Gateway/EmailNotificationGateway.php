<?php
declare(strict_types=1);

namespace App\Application\Infrastructure\Gateway;


use App\Application\Domain\Entity\User;
use App\Application\Domain\Exception\ValidateException;
use App\Application\Domain\Gateway\NotificationGatewayInterface;

class EmailNotificationGateway implements NotificationGatewayInterface
{
    public function userRegister(User $user): void
    {
        // TODO: Implement userRegister() method.
    }
}