<?php
declare(strict_types=1);

namespace App\Application\Infrastructure\Gateway;


use App\Application\Domain\Common\Constants\UserStatusConstants;
use App\Application\Domain\Entity\User;
use App\Application\Domain\Exception\GatewayException;
use App\Application\Domain\Gateway\UserHashGeneratorGatewayInterface;

class UserResetPasswordHashGeneratorGateway extends UserHashGeneratorGateway implements UserHashGeneratorGatewayInterface
{

    /**
     * @param User $user
     * @param int $length
     * @return string
     * @throws GatewayException
     */
    public function generate(User $user, int $length = 8): string
    {
        if ($user->getStatus() != UserStatusConstants::ACTIVE) {
            throw new GatewayException("Invalid user status [expect ACTIVE]");
        }

        return parent::generate($user, $length);
    }
}