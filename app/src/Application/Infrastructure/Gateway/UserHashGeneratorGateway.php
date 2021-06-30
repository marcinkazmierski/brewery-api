<?php
declare(strict_types=1);

namespace App\Application\Infrastructure\Gateway;


use App\Application\Domain\Entity\User;
use App\Application\Domain\Exception\GatewayException;
use App\Application\Domain\Gateway\UserHashGeneratorGatewayInterface;

abstract class UserHashGeneratorGateway implements UserHashGeneratorGatewayInterface
{
    /**
     * @param User $user
     * @param int $length
     * @return string
     * @throws GatewayException
     */
    public function generate(User $user, int $length = 32): string
    {
        $hash = hash('sha1', sprintf("%d-%s-%d", $user->getId(), $user->getEmail(), rand()));
        if (!$hash || !is_string($hash)) {
            throw new GatewayException("Error in hash() function");
        }

        return substr($hash, 0, $length);
    }

}