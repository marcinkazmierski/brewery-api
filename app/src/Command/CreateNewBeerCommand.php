<?php
declare(strict_types=1);

namespace App\Command;

use App\Application\Domain\UseCase\CreateBeer\CreateBeer;
use App\Application\Domain\UseCase\CreateBeer\CreateBeerPresenterInterface;
use App\Application\Domain\UseCase\CreateBeer\CreateBeerRequest;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * A console command for creating a new user
 *
 *
 *     $ php bin/console beer:create
 */
class CreateNewBeerCommand extends Command {


	protected static $defaultName = 'beer:create';


	private CreateBeer $useCase;


	private CreateBeerPresenterInterface $presenter;

	/**
	 * @param CreateBeer $useCase
	 * @param CreateBeerPresenterInterface $presenter
	 */
	public function __construct(CreateBeer $useCase, CreateBeerPresenterInterface $presenter) {
		parent::__construct();
		$this->useCase = $useCase;
		$this->presenter = $presenter;
	}


	/**
	 * {@inheritdoc}
	 */
	protected function configure() {
		$this
			// the short description shown while running "php bin/console list"
			->setDescription('Create new beer in database.')

			// the full command description shown when running the command with
			// the "--help" option
			->setHelp('This command allows you to create new beer.');
	}


	/**
	 * @param InputInterface $input
	 * @param OutputInterface $output
	 *
	 * @return int
	 */
	protected function execute(InputInterface $input, OutputInterface $output): int {
		/** @var \Symfony\Component\Console\Helper\QuestionHelper $helper */
		$helper = $this->getHelper('question');

		$question = new Question('Please enter the name of beer (for example: "Czerwony Kasztan"): ', '');
		$name = $helper->ask($input, $output, $question);

		$question = new Question('Please enter the description of beer: ', '');
		$description = $helper->ask($input, $output, $question);

		$question = new Question('Please enter the title of beer (for example: "Belgian Pale Ale 13BLG"): ', '');
		$title = $helper->ask($input, $output, $question);

		$question = new Question('Please enter the malts of beer: ', '');
		$malts = $helper->ask($input, $output, $question);

		$question = new Question('Please enter the hops of beer: ', '');
		$hops = $helper->ask($input, $output, $question);

		$question = new ChoiceQuestion(
			'Please select status: ',
			['inactive', 'visible/active']
		);
		$question->setErrorMessage('Status %s is invalid.');
		$status = (bool) $helper->ask($input, $output, $question);

		$question = new Question('Please enter the code of beer (min 5 chars): ', '');
		$code = $helper->ask($input, $output, $question);

		$question = new Question('Please enter the icon of beer: ', '');
		$icon = $helper->ask($input, $output, $question);

		$question = new Question('Please enter the background image of beer: ', '');
		$bg = $helper->ask($input, $output, $question);


		$question = new ChoiceQuestion(
			'Please select tags: ',
			[
				'IPA',
				'APA',
				'Polskie',
				'Pszeniczne',
				'Ciemne',
				'Jasne',
				'Fermentacja górna',
				'Fermentacja dolna',
				'Belgijskie',
				'Klasyczne',
				'Kwaśne',
				'Nowofalowe',
				'Owocowe',
			], //todo env/config
			''
		);
		$question->setMultiselect(TRUE);
		$tags = $helper->ask($input, $output, $question);

		$request = new CreateBeerRequest(
			$name, $title, $description, $malts, $hops, $status, $tags, $icon, $code, $bg
		);
		$this->useCase->execute($request, $this->presenter);
		$output->writeln($this->presenter->view());

		return Command::SUCCESS;
	}

}