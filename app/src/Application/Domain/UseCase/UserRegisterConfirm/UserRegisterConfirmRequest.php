<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\UserRegisterConfirm;

/**
 * Class UserRegisterConfirmRequest
 * @package App\Application\Domain\UseCase\UserRegisterConfirm
 */
class UserRegisterConfirmRequest
{
    /** @var string */
    private string $hash;

    /**
     * UserRegisterConfirmRequest constructor.
     * @param string $hash
     */
    public function __construct(string $hash)
    {
        $this->hash = $hash;
    }

    /**
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }

}
