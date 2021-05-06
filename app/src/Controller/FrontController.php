<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 * Class FrontController
 * @package App\Controller
 */
class FrontController extends AbstractController
{
    /**
     * @Route(
     *     "",
     *     name="index"
     * )
     * @return Response
     */
    public function index(): Response
    {
        return $this->render("bundles/TwigBundle/Exception/error403.html.twig", [], new Response('', Response::HTTP_FORBIDDEN));
    }
}
