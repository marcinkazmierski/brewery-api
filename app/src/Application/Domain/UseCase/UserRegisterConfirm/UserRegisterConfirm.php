<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\UserRegisterConfirm;

use App\Application\Domain\Common\Constants\UserStatusConstants;
use App\Application\Domain\Common\Factory\ErrorResponseFactory\ErrorResponseFromExceptionFactoryInterface;
use App\Application\Domain\Exception\ValidateException;
use App\Application\Domain\Repository\BeerRepositoryInterface;
use App\Application\Domain\Repository\UserRepositoryInterface;

/**
 * Class UserRegisterConfirm
 * @package App\Application\Domain\UseCase\UserRegisterConfirm
 */
class UserRegisterConfirm
{
    /** @var UserRepositoryInterface */
    private UserRepositoryInterface $userRepository;

    /** @var BeerRepositoryInterface */
    private BeerRepositoryInterface $beerRepository;

    /** @var ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory */
    private ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory;

    /**
     * @param UserRepositoryInterface $userRepository
     * @param BeerRepositoryInterface $beerRepository
     * @param ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory
     */
    public function __construct(UserRepositoryInterface $userRepository, BeerRepositoryInterface $beerRepository, ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory)
    {
        $this->userRepository = $userRepository;
        $this->beerRepository = $beerRepository;
        $this->errorResponseFromExceptionFactory = $errorResponseFromExceptionFactory;
    }

    /**
     * @param UserRegisterConfirmRequest $request
     * @param UserRegisterConfirmPresenterInterface $presenter
     */
    public function execute(
        UserRegisterConfirmRequest            $request,
        UserRegisterConfirmPresenterInterface $presenter)
    {
        $response = new UserRegisterConfirmResponse();
        try {
            if (empty($request->getHash())) {
                throw new ValidateException("Empty hash field");
            }
            if (!($user = $this->userRepository->findOneBy(['hash' => $request->getHash()]))) {
                throw new ValidateException("Invalid hash");
            }
            if ($user->getStatus() !== UserStatusConstants::NEW) {
                throw new ValidateException("Invalid user status");
            }
            $user->setStatus(UserStatusConstants::ACTIVE);
            $user->setHash(null);

            // add activeForAllUsers beers
            $beers = $this->beerRepository->findBy(['status' => 1, 'activeForAllUsers' => 1]);
            foreach ($beers as $beer) {
                if (!$user->getUnlockedBeers()->contains($beer)) {
                    $user->getUnlockedBeers()->add($beer);
                }
            }

            $this->userRepository->save($user);
        } catch (\Throwable $e) {
            $error = $this->errorResponseFromExceptionFactory->create($e);
            $response->setError($error);
        }
        $presenter->present($response);
    }
}
