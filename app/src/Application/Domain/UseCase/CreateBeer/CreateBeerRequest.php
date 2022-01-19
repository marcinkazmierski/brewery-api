<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\CreateBeer;

/**
 * Class CreateBeerRequest
 * @package App\Application\Domain\UseCase\CreateBeer
 */
class CreateBeerRequest
{
    /** @var string */
    private string $name = "";

    /** @var string */
    private string $title = "";

    /** @var string */
    private string $description;

    /** @var string */
    private string $malts;

    /** @var string */
    private string $hops;

    /** @var bool */
    private bool $status = true;

    /** @var array */
    private array $tags = [];

    /** @var string */
    private string $icon;

    /** @var string */
    private string $code;

    /** @var string */
    private string $backgroundImage;

    /**
     * @param string $name
     * @param string $title
     * @param string $description
     * @param string $malts
     * @param string $hops
     * @param bool $status
     * @param array $tags
     * @param string $icon
     * @param string $code
     * @param string $backgroundImage
     */
    public function __construct(string $name, string $title, string $description, string $malts, string $hops, bool $status, array $tags, string $icon, string $code, string $backgroundImage)
    {
        $this->name = $name;
        $this->title = $title;
        $this->description = $description;
        $this->malts = $malts;
        $this->hops = $hops;
        $this->status = $status;
        $this->tags = $tags;
        $this->icon = $icon;
        $this->code = $code;
        $this->backgroundImage = $backgroundImage;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getMalts(): string
    {
        return $this->malts;
    }

    /**
     * @return string
     */
    public function getHops(): string
    {
        return $this->hops;
    }

    /**
     * @return bool
     */
    public function isStatus(): bool
    {
        return $this->status;
    }

    /**
     * @return array
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getBackgroundImage(): string
    {
        return $this->backgroundImage;
    }


}
