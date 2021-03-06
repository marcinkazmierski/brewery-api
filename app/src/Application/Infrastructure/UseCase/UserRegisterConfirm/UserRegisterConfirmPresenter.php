<?php
declare(strict_types=1);

namespace App\Application\Infrastructure\UseCase\UserRegisterConfirm;

use App\Application\Domain\UseCase\UserRegisterConfirm\UserRegisterConfirmPresenterInterface;
use App\Application\Domain\UseCase\UserRegisterConfirm\UserRegisterConfirmResponse;
use App\Application\Infrastructure\Common\AbstractPresenter;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

/**
 * Class UserRegisterConfirmPresenter
 * @package App\Application\Infrastructure\UseCase\UserRegisterConfirm
 */
class UserRegisterConfirmPresenter extends AbstractPresenter implements UserRegisterConfirmPresenterInterface
{
    /** @var Environment */
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @var UserRegisterConfirmResponse $response
     */
    private $response;

    /**
     * @param UserRegisterConfirmResponse $response
     */
    public function present(UserRegisterConfirmResponse $response): void
    {
        $this->response = $response;
    }

    /**
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function view()
    {
        $response = new Response();
        $content = $this->twig->render("front/confirmation.html.twig", []);
        if ($this->response->hasError()) {
            $content = $this->twig->render("front/confirmation.html.twig", [
                'error' => $this->response->getError()->getMessage()
            ]);
        }

        $response->setContent($content);
        return $response;
    }
}
