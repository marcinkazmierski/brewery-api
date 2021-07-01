<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\UserResetPasswordConfirm;

use App\Application\Domain\Common\Constants\UserStatusConstants;
use App\Application\Domain\Common\Factory\ErrorResponseFactory\ErrorResponseFromExceptionFactoryInterface;
use App\Application\Domain\Exception\ValidateException;
use App\Application\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserResetPasswordConfirm
 * @package App\Application\Domain\UseCase\UserResetPasswordConfirm
 */
class UserResetPasswordConfirm
{
    /** @var UserRepositoryInterface */
    private UserRepositoryInterface $userRepository;

    /** @var UserPasswordEncoderInterface */
    private UserPasswordEncoderInterface $passwordEncoder;

    /** @var ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory */
    private ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory;

    /**
     * UserResetPasswordConfirm constructor.
     * @param UserRepositoryInterface $userRepository
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory
     */
    public function __construct(UserRepositoryInterface $userRepository, UserPasswordEncoderInterface $passwordEncoder, ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory)
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
        $this->errorResponseFromExceptionFactory = $errorResponseFromExceptionFactory;
    }


    /**
     * @param UserResetPasswordConfirmRequest $request
     * @param UserResetPasswordConfirmPresenterInterface $presenter
     */
    public function execute(
        UserResetPasswordConfirmRequest $request,
        UserResetPasswordConfirmPresenterInterface $presenter)
    {
        $response = new UserResetPasswordConfirmResponse();
        try {
            //TODO
            // todo: validate HashExpiryDate
            if (empty($request->getEmail())) {
                throw new ValidateException("Empty email field");
            }
            if (empty($request->getNewPassword()) || strlen($request->getNewPassword()) < 8) {
                throw new ValidateException("Invalid password field. Minimum password length: 8");
            }
            if (!($user = $this->userRepository->findOneBy(['hash' => $request->getHash()]))) {
                throw new ValidateException("Invalid hash");
            }
            if ($user->getHashExpiryDate() && $user->getHashExpiryDate()->getTimestamp() > (new \DateTime('now'))->getTimestamp()){
                throw new ValidateException("Hash has expired");
            }
            if ($user->getStatus() !== UserStatusConstants::NEW) {
                throw new ValidateException("Invalid user status");
            }
            $encodedPassword = $this->passwordEncoder->encodePassword($user, $request->getNewPassword());
            $user->setPassword($encodedPassword);
            $user->setHash(null);
            $this->userRepository->save($user);
        } catch (\Throwable $e) {
            $error = $this->errorResponseFromExceptionFactory->create($e);
            $response->setError($error);
        }
        $presenter->present($response);
    }
}
