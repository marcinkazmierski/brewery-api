<?php
declare(strict_types=1);


namespace App\Application\Domain\Gateway;


use App\Application\Domain\Entity\User;
use App\Application\Domain\Exception\GatewayException;

interface UserHashGeneratorGatewayInterface
{
    /**
     * @param User $user
     * @param int $length
     * @return string
     * @throws GatewayException
     */
    public function generate(User $user, int $length = 32): string;
}