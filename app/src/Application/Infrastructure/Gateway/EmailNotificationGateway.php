<?php
declare(strict_types=1);

namespace App\Application\Infrastructure\Gateway;

use App\Application\Domain\Entity\User;
use App\Application\Domain\Exception\GatewayException;
use App\Application\Domain\Gateway\NotificationGatewayInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class EmailNotificationGateway implements NotificationGatewayInterface
{
    /** @var MailerInterface */
    private MailerInterface $mailer;

    /** @var UrlGeneratorInterface */
    private UrlGeneratorInterface $router;

    private ContainerBagInterface $params;

    /** @var TranslatorInterface */
    private TranslatorInterface $translator;

    /**
     * @param MailerInterface $mailer
     * @param UrlGeneratorInterface $router
     * @param ContainerBagInterface $params
     * @param TranslatorInterface $translator
     */
    public function __construct(MailerInterface $mailer, UrlGeneratorInterface $router, ContainerBagInterface $params, TranslatorInterface $translator)
    {
        $this->mailer = $mailer;
        $this->router = $router;
        $this->params = $params;
        $this->translator = $translator;
    }


    /**
     * @param User $user
     * @param string $confirmHash
     * @throws GatewayException
     */
    public function userRegister(User $user, string $confirmHash): void
    {
        try {
            $sender = $this->params->get('mailer_sender');

            $email = (new TemplatedEmail())
                ->from(new Address($sender, 'Zdalny Browar'))
                ->to($user->getEmail())
                ->subject($this->translator->trans('Confirm your account!'))
                ->htmlTemplate('emails/registration.html.twig')
                ->context([
                    'user' => $user,
                    'link' => $this->router->generate('confirm-user-account', ['hash' => $confirmHash], UrlGeneratorInterface::ABSOLUTE_URL),
                ]);

            $this->mailer->send($email);
        } catch (\Throwable $e) {
            throw new GatewayException($e->getMessage());
        }
    }

    /**
     * @param User $user
     * @param string $resetPasswordTemporaryCode
     * @throws GatewayException
     */
    public function userResetPassword(User $user, string $resetPasswordTemporaryCode): void
    {
        try {
            $sender = $this->params->get('mailer_sender');

            $email = (new TemplatedEmail())
                ->from(new Address($sender, 'Zdalny Browar'))
                ->to($user->getEmail())
                ->subject($this->translator->trans('Reset your password!'))
                ->htmlTemplate('emails/reset-password.html.twig')
                ->context([
                    'user' => $user,
                    'code' => $resetPasswordTemporaryCode,
                ]);

            $this->mailer->send($email);
        } catch (\Throwable $e) {
            throw new GatewayException($e->getMessage());
        }
    }
}