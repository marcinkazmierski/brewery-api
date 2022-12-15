<?php

namespace App\Command;

use App\Application\Domain\Common\Constants\UserStatusConstants;
use App\Application\Domain\Repository\UserRepositoryInterface;
use Google\CRC32\PHP;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpKernel\KernelInterface;

#[AsCommand(
    name: 'users:push-notifications',
    description: 'Send push notifications via firebase.',
)]
class UsersPushNotificationsCommand extends Command
{
    private UserRepositoryInterface $userRepository;

    /**
     * @var KernelInterface
     */
    protected $kernel;

    /**
     * @param UserRepositoryInterface $userRepository
     * @param KernelInterface $kernel
     */
    public function __construct(UserRepositoryInterface $userRepository, KernelInterface $kernel)
    {
        $this->userRepository = $userRepository;
        $this->kernel = $kernel;
        parent::__construct();
    }


    protected function configure(): void
    {
        $this
            ->addArgument('title', InputArgument::REQUIRED, 'Message title')
            ->addArgument('body', InputArgument::REQUIRED, 'Message body')
            ->addArgument('nick', InputArgument::OPTIONAL, 'User nick')
            ->addOption('all', null, InputOption::VALUE_NONE, 'Send to all users');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $title = $input->getArgument('title');
        $body = $input->getArgument('body');
        $nick = $input->getArgument('nick');
        $deviceTokens = [];

        if ($input->getOption('all')) {
            foreach ($this->userRepository->findBy(['status' => [UserStatusConstants::ACTIVE, UserStatusConstants::GUEST, UserStatusConstants::GUEST_WAIT_FOR_CONFIRMATION]]) as $user) {
                if (!empty($user->getNotificationToken())) {
                    $deviceTokens[] = $user->getNotificationToken();
                }
            }
        } else if ($nick) {
            $io->note(sprintf('Your nick: %s', $nick));
            $user = $this->userRepository->getUserByNick($nick);
            if (!empty($user->getNotificationToken())) {
                $deviceTokens[] = $user->getNotificationToken();
            }
        }

        if (!empty($deviceTokens)) {
            $io->text(sprintf("Title: %s", $title));
            $io->text(sprintf("Body:  %s", $body));

            $factory = (new Factory())->withServiceAccount($this->kernel->getProjectDir() . '/firebase/credentials.json');
            $messaging = $factory->createMessaging();
            $message = CloudMessage::new()
                ->withNotification(Notification::create($title, $body));
            $report = $messaging->sendMulticast($message, $deviceTokens);

            $io->success('Successful sends: ' . $report->successes()->count());
            $io->warning('Failed sends: ' . $report->failures()->count());

            if ($report->hasFailures()) {
                foreach ($report->failures()->getItems() as $failure) {
                    $io->error($failure->error()->getMessage() . "; TARGET: " . $failure->target()->value());
                }
            }
        }

        return Command::SUCCESS;
    }
}
