<?php
declare(strict_types=1);
namespace App\Application\Domain\UseCase\GetApiDocumentation;

use App\Application\Domain\Common\Factory\ErrorResponseFactory\ErrorResponseFromExceptionFactoryInterface;

/**
 * Class GetApiDocumentation
 * @package App\Application\Domain\UseCase\GetApiDocumentation
 */
class GetApiDocumentation
{
    const CONTROLLERS_PATH = "./../src/Controller";

    /** @var ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory */
    private $errorResponseFromExceptionFactory;

    /**
     * GetApiDocumentation constructor.
     * @param ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory
     */
    public function __construct
    (
        ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory
    )
    {
        $this->errorResponseFromExceptionFactory = $errorResponseFromExceptionFactory;
    }

    /**
     * @param GetApiDocumentationRequest $request
     * @param GetApiDocumentationPresenterInterface $presenter
     */
    public function execute(
        GetApiDocumentationRequest $request,
        GetApiDocumentationPresenterInterface $presenter)
    {
        $response = new GetApiDocumentationResponse();
        try {
            $openapi = \OpenApi\scan(self::CONTROLLERS_PATH);
            $yaml = $openapi->toYaml();
            $response->setApiDocumentation($yaml);
        } catch (\Throwable $e) {
            $error = $this->errorResponseFromExceptionFactory->create($e);
            $response->setError($error);
        }
        $presenter->present($response);
    }
}
