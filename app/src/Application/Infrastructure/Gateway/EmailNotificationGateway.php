<?php
declare(strict_types=1);

namespace App\Application\Infrastructure\Gateway;


use App\Application\Domain\Entity\User;
use App\Application\Domain\Exception\GatewayException;
use App\Application\Domain\Exception\ValidateException;
use App\Application\Domain\Gateway\NotificationGatewayInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Message;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class EmailNotificationGateway implements NotificationGatewayInterface
{
    /** @var MailerInterface */
    private MailerInterface $mailer;

    /** @var UrlGeneratorInterface */
    private UrlGeneratorInterface $router;

    private ContainerBagInterface $params;

    /**
     * EmailNotificationGateway constructor.
     * @param MailerInterface $mailer
     * @param UrlGeneratorInterface $router
     * @param ContainerBagInterface $params
     */
    public function __construct(MailerInterface $mailer, UrlGeneratorInterface $router, ContainerBagInterface $params)
    {
        $this->mailer = $mailer;
        $this->router = $router;
        $this->params = $params;
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
                ->subject('Time for Symfony Mailer!')
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
}