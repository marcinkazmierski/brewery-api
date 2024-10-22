<?php

namespace App\Application\Domain\Common\Command;

use App\Application\Domain\Entity\User;
use App\Application\Domain\Repository\BeerRepositoryInterface;
use App\Application\Domain\Repository\UserRepositoryInterface;

class CollectUnlockedBeersCommand
{
    /** @var UserRepositoryInterface */
    private UserRepositoryInterface $userRepository;

    /** @var BeerRepositoryInterface */
    private BeerRepositoryInterface $beerRepository;

    /**
     * @param UserRepositoryInterface $userRepository
     * @param BeerRepositoryInterface $beerRepository
     */
    public function __construct(UserRepositoryInterface $userRepository, BeerRepositoryInterface $beerRepository)
    {
        $this->userRepository = $userRepository;
        $this->beerRepository = $beerRepository;
    }

    /**
     * Add activeForAllUsers beers.
     * @param User $user
     * @return void
     * @throws \Exception
     */
    public function execute(User $user): void
    {
        $beers = $this->beerRepository->findByCriteria(['status' => 1, 'activeForAllUsers' => 1]);
        foreach ($beers as $beer) {
            if (!$user->getUnlockedBeers()->contains($beer)) {
                $user->getUnlockedBeers()->add($beer);
            }
        }
        $this->userRepository->save($user);
    }
}