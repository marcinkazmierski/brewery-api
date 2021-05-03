<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserRepository extends ServiceEntityRepository implements UserLoaderInterface
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * UserRepository constructor.
     * @param ManagerRegistry $registry
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(ManagerRegistry $registry, UserPasswordEncoderInterface $encoder)
    {
        parent::__construct($registry, User::class);
        $this->passwordEncoder = $encoder;
    }

    /**
     * @param string $username
     * @return User|null
     */
    public function loadUserByUsername(string $username): ?User
    {
        try {
            return $this->getUserByEmail($username);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @param string $email
     * @return User
     * @throws \Exception
     */
    public function getUserByEmail(string $email): User
    {
        /** @var User $user */
        $user = $this->findOneBy(['email' => $email]);
        if (!$user) {
            throw new \Exception("User not found");
        }
        return $user;
    }

    /**
     * @param User $entity
     * @throws \Exception
     */
    public function save(User $entity): void
    {
        try {
            $this->_em->persist($entity);
            $this->_em->flush();
        } catch (ORMException $e) {
            $this->_em->rollback();
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param string $email
     * @param string $password
     * @return User
     * @throws \Exception
     */
    public function getUserByEmailAndPassword(string $email, string $password): User
    {
        $user = $this->getUserByEmail($email);
        if (!$this->passwordEncoder->isPasswordValid($user, $password)) {
            throw new \Exception("Invalid password");
        }
        return $user;
    }
}