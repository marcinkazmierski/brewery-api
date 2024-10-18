<?php
declare(strict_types=1);

namespace App\Command;

use App\Application\Domain\UseCase\CollectBeer\CollectBeer;
use App\Application\Domain\UseCase\CollectBeer\CollectBeerPresenterInterface;
use App\Application\Domain\UseCase\CollectBeer\CollectBeerRequest;
use App\Application\Infrastructure\Repository\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * A console command for collect beer
 *
 *
 *     $ php bin/console beer:collect BEER_CODE USER_EMAIL
 */
#[AsCommand(name: 'beer:collect')]
class CollectBeerCommand extends Command
{
    const PARAM_BEER = 'beer-code';
    const PARAM_EMAIL = 'user-email';

    /** @var UserRepository */
    private UserRepository $userRepository;

    /** @var CollectBeer */
    private CollectBeer $useCase;

    /** @var CollectBeerPresenterInterface */
    private CollectBeerPresenterInterface $presenter;

    /**
     * @param UserRepository $userRepository
     * @param CollectBeer $useCase
     * @param CollectBeerPresenterInterface $presenter
     */
    public function __construct(UserRepository $userRepository, CollectBeer $useCase, CollectBeerPresenterInterface $presenter)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
        $this->useCase = $useCase;
        $this->presenter = $presenter;
    }


    /**
     * {@inheritdoc}
     */
    protected function configure(): void {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Add beer to user collection.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to add beer to user collection.')
            ->addArgument(
                self::PARAM_BEER,
                InputArgument::REQUIRED,
                'Beer code'
            )
            ->addArgument(
                self::PARAM_EMAIL,
                InputArgument::REQUIRED,
                'User email'
            );
    }


    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $email = (string)$input->getArgument(self::PARAM_EMAIL);
        $beerCode = (string)$input->getArgument(self::PARAM_BEER);

        try {
            $user = $this->userRepository->getUserByEmail($email);

            $input = new CollectBeerRequest($user, $beerCode);
            $this->useCase->execute($input, $this->presenter);

            $output->writeln($this->presenter->view());
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $output->writeln(sprintf('Account not exist! email: "%s"', $email));
            return Command::FAILURE;
        }

    }
}