<?php
declare(strict_types=1);

namespace App\Command;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * A console command for generate useCase
 *
 *
 *     $ php bin/console code:generator:usecase MyUseCaseName
 */
class CreateNewUseCaseCommand extends Command
{
    const PARAM_USE_CASE_NAME = 'use_case_name';
    const DOMAIN_PATH = '/src/Application/Domain/UseCase/';
    const INFRASTRUCTURE_PATH = '/src/Application/Infrastructure/UseCase/';

    protected static $defaultName = 'code:generator:usecase';

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var KernelInterface
     */
    protected $kernel;

    /**
     * CreateNewUseCase constructor.
     * @param LoggerInterface $logger
     * @param KernelInterface $kernel
     */
    public function __construct(
        LoggerInterface $logger,
        KernelInterface $kernel
    )
    {
        $this->logger = $logger;
        $this->kernel = $kernel;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->addArgument(
                self::PARAM_USE_CASE_NAME,
                InputArgument::REQUIRED,
                'UseCase name'
            );
    }


    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = (string)$input->getArgument(self::PARAM_USE_CASE_NAME);

        if (strlen($name) < 3) {
            throw new  InvalidArgumentException("Invalid use case name!");
        }

        $dirDomain = $this->kernel->getProjectDir() . self::DOMAIN_PATH . $name;
        $dirInfrastructure = $this->kernel->getProjectDir() . self::INFRASTRUCTURE_PATH . $name;

        if (!is_dir($dirDomain)) {
            mkdir($dirDomain);
        }
        if (!is_dir($dirInfrastructure)) {
            mkdir($dirInfrastructure);
        }

        $useCase = <<<PHP
<?php
declare(strict_types=1);
namespace App\\Application\\Domain\\UseCase\\{$name};

use App\\Application\\Domain\\Common\\Factory\\ErrorResponseFactory\\ErrorResponseFromExceptionFactoryInterface;

/**
 * Class {$name}
 * @package App\\Application\\Domain\\UseCase\\{$name}
 */
class {$name}
{
    /** @var ErrorResponseFromExceptionFactoryInterface \$errorResponseFromExceptionFactory */
    private \$errorResponseFromExceptionFactory;

    /**
     * {$name} constructor.
     * @param ErrorResponseFromExceptionFactoryInterface \$errorResponseFromExceptionFactory
     */
    public function __construct
    (
        ErrorResponseFromExceptionFactoryInterface \$errorResponseFromExceptionFactory
    )
    {
        \$this->errorResponseFromExceptionFactory = \$errorResponseFromExceptionFactory;
    }

    /**
     * @param {$name}Request \$request
     * @param {$name}PresenterInterface \$presenter
     */
    public function execute(
        {$name}Request \$request,
        {$name}PresenterInterface \$presenter)
    {
        \$response = new {$name}Response();
        try {
            //TODO
        } catch (\\Throwable \$e) {
            \$error = \$this->errorResponseFromExceptionFactory->create(\$e);
            \$response->setError(\$error);
        }
        \$presenter->present(\$response);
    }
}

PHP;

        $request = <<<PHP
<?php
declare(strict_types=1);
namespace App\\Application\\Domain\\UseCase\\{$name};

/**
 * Class {$name}Request
 * @package App\\Application\\Domain\\UseCase\\{$name}
 */
class {$name}Request
{

}

PHP;

        $response = <<<PHP
<?php
declare(strict_types=1);
namespace App\\Application\\Domain\\UseCase\\{$name};

use App\\Application\\Domain\\Common\\Response\\AbstractResponse;

/**
 * Class {$name}Response
 * @package App\\Application\\Domain\\UseCase\\{$name}
 */
class {$name}Response extends AbstractResponse
{

}

PHP;

        $presenterInterface = <<<PHP
<?php
declare(strict_types=1);
namespace App\\Application\\Domain\\UseCase\\{$name};

/**
 * Interface {$name}PresenterInterface
 * @package App\\Application\\Domain\\UseCase\\{$name}
 */
interface {$name}PresenterInterface
{
    /**
     * @param {$name}Response \$response
     */
    public function present({$name}Response \$response): void;

    /**
     * @return mixed
     */
    public function view();
}

PHP;

        $presenter = <<<PHP
<?php
declare(strict_types=1);
namespace App\\Application\\Infrastructure\\UseCase\\{$name};

use App\\Application\\Domain\\UseCase\\{$name}\\{$name}PresenterInterface;
use App\\Application\\Domain\\UseCase\\{$name}\\{$name}Response;
use App\\Application\\Infrastructure\\Common\\AbstractPresenter;
use Symfony\\Component\\HttpFoundation\\JsonResponse;

/**
 * Class {$name}Presenter
 * @package App\\Application\\Infrastructure\\UseCase\\{$name}
 */
class {$name}Presenter extends AbstractPresenter implements {$name}PresenterInterface
{
    /**
     * @var {$name}Response \$response
     */
    private \$response;

    /**
     * @param {$name}Response \$response
     */
    public function present({$name}Response \$response): void
    {
        \$this->response = \$response;
    }

    /**
     * @return JsonResponse
     */
    public function view()
    {
        if (\$this->response->hasError()) {
            \$statusCode = JsonResponse::HTTP_BAD_REQUEST;
            return \$this->viewErrorResponse(\$this->response->getError(), \$statusCode);
        }
        
        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}

PHP;
        // validate
        if (!$this->fileValidate($dirDomain . DIRECTORY_SEPARATOR . $name . '.php', $output)) {
            return Command::FAILURE;
        }
        if (!$this->fileValidate($dirDomain . DIRECTORY_SEPARATOR . $name . 'Request.php', $output)) {
            return Command::FAILURE;
        }
        if (!$this->fileValidate($dirDomain . DIRECTORY_SEPARATOR . $name . 'Response.php', $output)) {
            return Command::FAILURE;
        }
        if (!$this->fileValidate($dirDomain . DIRECTORY_SEPARATOR . $name . 'PresenterInterface.php', $output)) {
            return Command::FAILURE;
        }
        if (!$this->fileValidate($dirInfrastructure . DIRECTORY_SEPARATOR . $name . 'Presenter.php', $output)) {
            return Command::FAILURE;
        }

        file_put_contents($dirDomain . DIRECTORY_SEPARATOR . $name . '.php', $useCase);
        file_put_contents($dirDomain . DIRECTORY_SEPARATOR . $name . 'Request.php', $request);
        file_put_contents($dirDomain . DIRECTORY_SEPARATOR . $name . 'Response.php', $response);
        file_put_contents($dirDomain . DIRECTORY_SEPARATOR . $name . 'PresenterInterface.php', $presenterInterface);
        file_put_contents($dirInfrastructure . DIRECTORY_SEPARATOR . $name . 'Presenter.php', $presenter);


        $output->writeln(
            sprintf('Created new use case "%s" in "%s" with presenter in "%s"', $name, $dirDomain, $dirInfrastructure)
        );
        return Command::SUCCESS;
    }

    /**
     * @param $path
     * @param OutputInterface $output
     * @return bool
     */
    protected function fileValidate($path, OutputInterface $output): bool
    {
        if (file_exists($path)) {
            $output->writeln(sprintf('File "%s" already exist!', $path));
            return false;
        }

        return true;
    }
}
