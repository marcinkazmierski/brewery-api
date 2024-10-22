<?php
declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use App\Application\Domain\Common\Command\CollectUnlockedBeersCommand;
use App\Application\Domain\Common\Constants\UserStatusConstants;
use App\Application\Domain\Entity\User;
use App\Application\Infrastructure\Repository\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * A console command for creating a new user
 *
 *
 *     $ php bin/console users:create EMAIL NICK PASSWORD
 */
#[AsCommand(name: 'users:create')]
class CreateNewUserCommand extends Command {

	const PARAM_NICK = 'nick';

	const PARAM_EMAIL = 'email';

	const PARAM_PASSWORD = 'password';

	const OPTION_IS_ADMIN = 'admin';


	/** @var UserRepository */
	private UserRepository $userRepository;

	/** @var UserPasswordHasherInterface */
	private UserPasswordHasherInterface $passwordEncoder;


	/** @var CollectUnlockedBeersCommand */
	private CollectUnlockedBeersCommand $collectUnlockedBeersCommand;

	/**
	 * CreateNewUserCommand constructor.
	 *
	 * @param UserRepository $userRepository
	 * @param UserPasswordHasherInterface $passwordEncoder
	 */
	public function __construct(UserRepository $userRepository, UserPasswordHasherInterface $passwordEncoder, CollectUnlockedBeersCommand $collectUnlockedBeersCommand) {
		parent::__construct();
		$this->userRepository = $userRepository;
		$this->passwordEncoder = $passwordEncoder;
		$this->collectUnlockedBeersCommand = $collectUnlockedBeersCommand;
	}


	/**
	 * {@inheritdoc}
	 */
	protected function configure(): void {
		$this
			// the short description shown while running "php bin/console list"
			->setDescription('Create new user in database.')

			// the full command description shown when running the command with
			// the "--help" option
			->setHelp('This command allows you to create new user...')
			->addArgument(
				self::PARAM_EMAIL,
				InputArgument::REQUIRED,
				'Email'
			)
			->addArgument(
				self::PARAM_NICK,
				InputArgument::REQUIRED,
				'Nick'
			)
			->addArgument(
				self::PARAM_PASSWORD,
				InputArgument::REQUIRED,
				'Password'
			)->addOption(self::OPTION_IS_ADMIN);
	}


	/**
	 * @param InputInterface $input
	 * @param OutputInterface $output
	 */
	protected function execute(InputInterface $input, OutputInterface $output): int {
		try {
			$nick = (string) $input->getArgument(self::PARAM_NICK);
			$email = (string) $input->getArgument(self::PARAM_EMAIL);
			$password = (string) $input->getArgument(self::PARAM_PASSWORD);

			try {
				$user = $this->userRepository->getUserByEmail($email);

				$output->writeln(sprintf('Account exist! ID: "%d"', $user->getId()));
				return Command::FAILURE;
			} catch (\Exception $e) {
				$user = new User();
				$user->setEmail($email);
				$user->setNick($nick);
				$user->setStatus(UserStatusConstants::ACTIVE);
				$encodedPassword = $this->passwordEncoder->hashPassword($user, $password);
				$user->setPassword($encodedPassword);

				if ($input->getOption(self::OPTION_IS_ADMIN)) {
					$user->addRole('ROLE_ADMIN');
				}
				$this->userRepository->save($user);
				$this->collectUnlockedBeersCommand->execute($user);
				$output->writeln(sprintf('New account created! ID: "%d"', $user->getId()));
				return Command::SUCCESS;
			}


		} catch (\Throwable $exception) {
			$output->writeln(sprintf('Exception "%s"', $exception->getMessage()));
			return Command::FAILURE;
		}
	}

}