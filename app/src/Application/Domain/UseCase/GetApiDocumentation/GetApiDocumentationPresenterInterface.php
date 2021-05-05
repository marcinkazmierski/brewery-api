<?php
declare(strict_types=1);
namespace App\Application\Domain\UseCase\GetApiDocumentation;

/**
 * Interface GetApiDocumentationPresenterInterface
 * @package App\Application\Domain\UseCase\GetApiDocumentation
 */
interface GetApiDocumentationPresenterInterface
{
    /**
     * @param GetApiDocumentationResponse $response
     */
    public function present(GetApiDocumentationResponse $response): void;

    /**
     * @return mixed
     */
    public function view();
}
