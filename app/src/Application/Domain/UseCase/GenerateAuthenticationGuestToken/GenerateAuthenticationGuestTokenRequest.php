<?php
declare(strict_types=1);
namespace App\Application\Domain\UseCase\GenerateAuthenticationGuestToken;

/**
 * Class GenerateAuthenticationGuestTokenRequest
 * @package App\Application\Domain\UseCase\GenerateAuthenticationGuestToken
 */
class GenerateAuthenticationGuestTokenRequest
{
    private string $nick;
    private string $deviceId;
    private string $appVersion;

    /**
     * @param string $nick
     * @param string $deviceId
     * @param string $appVersion
     */
    public function __construct(string $nick, string $deviceId, string $appVersion)
    {
        $this->nick = $nick;
        $this->deviceId = $deviceId;
        $this->appVersion = $appVersion;
    }

    /**
     * @return string
     */
    public function getNick(): string
    {
        return $this->nick;
    }

    /**
     * @return string
     */
    public function getDeviceId(): string
    {
        return $this->deviceId;
    }

    /**
     * @return string
     */
    public function getAppVersion(): string
    {
        return $this->appVersion;
    }
}
