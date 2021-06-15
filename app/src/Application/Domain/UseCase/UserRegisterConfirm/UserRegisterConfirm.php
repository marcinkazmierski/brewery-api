<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\UserRegisterConfirm;

use App\Application\Domain\Common\Constants\UserStatusConstants;
use App\Application\Domain\Common\Factory\ErrorResponseFactory\ErrorResponseFromExceptionFactoryInterface;
use App\Application\Domain\Exception\ValidateException;
use App\Application\Domain\Repository\UserRepositoryInterface;

/**
 * Class UserRegisterConfirm
 * @package App\Application\Domain\UseCase\UserRegisterConfirm
 */
class UserRegisterConfirm
{
    /** @var UserRepositoryInterface */
    private UserRepositoryInterface $userRepository;

    /** @var ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory */
    private ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory;

    /**
     * UserRegisterConfirm constructor.
     * @param UserRepositoryInterface $userRepository
     * @param ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory
     */
    public function __construct(UserRepositoryInterface $userRepository, ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory)
    {
        $this->userRepository = $userRepository;
        $this->errorResponseFromExceptionFactory = $errorResponseFromExceptionFactory;
    }


    /**
     * @param UserRegisterConfirmRequest $request
     * @param UserRegisterConfirmPresenterInterface $presenter
     */
    public function execute(
        UserRegisterConfirmRequest $request,
        UserRegisterConfirmPresenterInterface $presenter)
    {
        $response = new UserRegisterConfirmResponse();
        try {
            if (empty($request->getHash())) {
                throw new ValidateException("Empty hash field");
            }
            if (!($user = $this->userRepository->findOneBy(['registrationHash' => $request->getHash()]))) {
                throw new ValidateException("Invalid hash");
            }
            if ($user->getStatus() !== UserStatusConstants::NEW) {
                throw new ValidateException("Invalid user status");
            }
            $user->setStatus(UserStatusConstants::ACTIVE);
            $user->setHash(null);
            $this->userRepository->save($user);
        } catch (\Throwable $e) {
            $error = $this->errorResponseFromExceptionFactory->create($e);
            $response->setError($error);
        }
        $presenter->present($response);
    }
}
