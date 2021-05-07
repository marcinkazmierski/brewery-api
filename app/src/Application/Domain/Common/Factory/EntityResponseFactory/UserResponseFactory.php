<?php


namespace App\Application\Domain\Common\Factory\EntityResponseFactory;


use App\Application\Domain\Common\Mapper\ResponseFieldMapper;
use App\Application\Domain\Entity\User;

class UserResponseFactory
{
    /**
     * @param User $entity
     * @return array
     */
    public function create(User $entity): array
    {
        return [
            ResponseFieldMapper::USER_ID => $entity->getId(),
            ResponseFieldMapper::USER_NICK => $entity->getNick(),
        ];
    }
}