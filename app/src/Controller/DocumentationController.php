<?php
declare(strict_types=1);

namespace App\Controller;

use App\Application\Domain\UseCase\GetApiDocumentation\GetApiDocumentation;
use App\Application\Domain\UseCase\GetApiDocumentation\GetApiDocumentationPresenterInterface;
use App\Application\Domain\UseCase\GetApiDocumentation\GetApiDocumentationRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Annotations as OA;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @OA\Info(title="Brewery REST API", version="0.1")
 *
 * @Route("/documentation")
 */
class DocumentationController extends AbstractController
{
    /**
     * @Route(
     *     "/yaml",
     *     methods={"GET"},
     *     name="documentation_api_yaml"
     * )
     *
     * @param GetApiDocumentation $getApiDocumentation
     * @param GetApiDocumentationPresenterInterface $presenter
     * @return mixed
     */
    public function generateDocsYaml(
        GetApiDocumentation $getApiDocumentation,
        GetApiDocumentationPresenterInterface $presenter
    )
    {
        $getApiDocumentation->execute(new GetApiDocumentationRequest(), $presenter);
        return $presenter->view();
    }

    /**
     * @Route(
     *     "/api",
     *     methods={"GET"},
     *     name="documentation_api"
     * )
     *
     * @return Response
     */
    public function api()
    {
        return $this->render('documentation/api.html.twig', []);
    }

}


/**
 * @OA\Schema(
 *    schema="ErrorResponse",
 *    type = "object",
 *    @OA\Property(
 *        property = "error",
 *        type = "object",
 *        @OA\Property( property = "code", type = "string", example="1001"),
 *        @OA\Property( property = "message", type = "string", example="General error"),
 *        @OA\Property( property = "userMessage", type = "string", example="Failed! Something has gone wrong. Please contact a system administrator."),
 *    ),
 * ),
 *
 * @OA\Schema(
 *    schema="id",
 *    type="integer",
 *    example=123,
 * ),
 *
 * @OA\Schema(
 *    schema="timestamp",
 *    type="integer",
 *    example=502947200,
 * ),
 *
 * @OA\Schema(
 *    schema="number",
 *    type="integer",
 *    example=123,
 * ),
 *
 * @OA\Schema(
 *     schema="token",
 *     description="User auth access token",
 *     type="string",
 *     example="8a4ee6defb35d3ec89fef66321284ae4137ba0c48c5c63de90ea7956e13cd975a51cceae0b2a1111e7e561a5ed0e",
 * ),
 *
 * @OA\Schema(
 *     schema="userId",
 *     description="User ID",
 *     type="integer",
 *     example="12345",
 * ),
 *
 * @OA\Schema(
 *     schema="email",
 *     description="User email",
 *     type="string",
 *     example="test@codeall.pl",
 * ),
 *
 * @OA\Schema(
 *     schema="hash",
 *     description="Unique user hash",
 *     type="string",
 *     example="52516fb79a0ecb2b0b35681fb94abc6909b5fd1f23c",
 * ),
 *
 * @OA\Schema(
 *     schema="password",
 *     description="User account password",
 *     type="string",
 *     example="SecretPassword",
 * ),
 *
 * @OA\Schema(
 *     schema="text",
 *     description="Some text",
 *     type="string",
 *     example="Lorem ipsum dolor sit amet...",
 * ),
 *
 * @OA\Parameter(
 *      name="X-AUTH-TOKEN",
 *      in="header",
 *      required=true,
 *      description="User access token",
 *      @OA\Schema(ref="#/components/schemas/token"),
 * ),
 *
 * @OA\Components(
 *     @OA\Response(
 *         response="generalError",
 *         description="Internal Server Error",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse"),
 *     ),
 *     @OA\Response(
 *         response="invalidToken",
 *         description="Invalid token",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse"),
 *     ),
 *     @OA\Response(
 *         response="badRequest",
 *         description="Bad Request. Path parameters do not reflect any resources in the database and/or body parameter are invalid.",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse"),
 *     ),
 *     @OA\Response(
 *         response="noContent",
 *         description="No Content. The server successfully processed the request and is not returning any content.",
 *     ),
 *     @OA\Response(
 *         response="created",
 *         description="The request has been fulfilled, resulting in the creation of a new resource.",
 *     ),
 * ),
 */