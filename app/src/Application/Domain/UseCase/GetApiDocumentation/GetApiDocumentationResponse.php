<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\GetApiDocumentation;

use App\Application\Domain\Common\Response\AbstractResponse;

/**
 * Class GetApiDocumentationResponse
 * @package App\Application\Domain\UseCase\GetApiDocumentation
 */
class GetApiDocumentationResponse extends AbstractResponse
{
    /** @var string */
    protected $apiDocumentation = '';

    /**
     * @return string
     */
    public function getApiDocumentation(): string
    {
        return $this->apiDocumentation;
    }

    /**
     * @param string $apiDocumentation
     */
    public function setApiDocumentation(string $apiDocumentation): void
    {
        $this->apiDocumentation = $apiDocumentation;
    }
}
