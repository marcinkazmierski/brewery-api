<?php
declare(strict_types=1);


namespace App\Application\Domain\Gateway;


use App\Application\Domain\Entity\User;
use App\Application\Domain\Exception\GatewayException;

interface UserRegistrationConfirmHashGeneratorGatewayInterface
{
    /**
     * @param User $user
     * @return string
     * @throws GatewayException
     */
    public function generate(User $user): string;

    /**
     * @param User $user
     * @param string $hash
     * @return bool
     */
    public function validate(User $user, string $hash): bool;
}