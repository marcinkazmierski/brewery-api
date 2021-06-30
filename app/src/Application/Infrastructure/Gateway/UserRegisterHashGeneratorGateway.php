<?php
declare(strict_types=1);

namespace App\Application\Infrastructure\Gateway;


use App\Application\Domain\Common\Constants\UserStatusConstants;
use App\Application\Domain\Entity\User;
use App\Application\Domain\Exception\GatewayException;
use App\Application\Domain\Gateway\UserHashGeneratorGatewayInterface;

class UserRegisterHashGeneratorGateway extends UserHashGeneratorGateway implements UserHashGeneratorGatewayInterface
{
    /**
     * @param User $user
     * @param int $length
     * @return string
     * @throws GatewayException
     */
    public function generate(User $user, int $length = 40): string
    {
        if ($user->getStatus() != UserStatusConstants::NEW) {
            throw new GatewayException("Invalid user status [expect NEW]");
        }

        return parent::generate($user, $length);
    }
}