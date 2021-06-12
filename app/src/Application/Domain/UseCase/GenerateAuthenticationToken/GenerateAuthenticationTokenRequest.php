<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\GenerateAuthenticationToken;

/**
 * Class GenerateAuthenticationTokenRequest
 * @package App\Application\Domain\UseCase\GenerateAuthenticationToken
 */
class GenerateAuthenticationTokenRequest
{
    /**
     * @var string
     */
    protected string $email;

    /**
     * @var string
     */
    protected string $password;

    /**
     * @var string
     */
    protected string $appVersion;

    /**
     * GenerateAuthenticationTokenRequest constructor.
     * @param string $email
     * @param string $password
     * @param string $appVersion
     */
    public function __construct(string $email, string $password, string $appVersion)
    {
        $this->email = $email;
        $this->password = $password;
        $this->appVersion = $appVersion;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getAppVersion(): string
    {
        return $this->appVersion;
    }
}
