<?php
declare(strict_types=1);

namespace App\Application\Infrastructure\Gateway;


use App\Application\Domain\Entity\User;
use App\Application\Domain\Exception\ValidateException;
use App\Application\Domain\Gateway\NotificationGatewayInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class EmailNotificationGateway implements NotificationGatewayInterface
{
    private MailerInterface $mailer;

    /**
     * EmailNotificationGateway constructor.
     * @param MailerInterface $mailer
     */
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function userRegister(User $user): void
    {
        // TODO: Implement userRegister() method.
        $email = (new TemplatedEmail())
            ->from(new Address('zdalny-browar@kazmierski.com.pl', 'Zdalny Browar'))
            ->to('marcin@kazmierski.com.pl')
            ->subject('Time for Symfony Mailer!')
            ->htmlTemplate('emails/registration.html.twig')
            ->context([
                'user' =>$user,
            ]);

        $this->mailer->send($email);
    }
}