<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\Application\Domain\Entity\Beer;
use App\Application\Domain\Entity\Review;
use App\Application\Domain\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UsersFixtures extends Fixture
{
    /** @var UserPasswordHasherInterface */
    private UserPasswordHasherInterface $passwordEncoder;

    /**
     * UsersFixtures constructor.
     * @param UserPasswordHasherInterface $passwordEncoder
     */
    public function __construct(UserPasswordHasherInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail("test@test.pl");
        $user->setNick("Testowy");
        $password = "test";
        $encodedPassword = $this->passwordEncoder->hashPassword($user, $password);
        $user->setPassword($encodedPassword);

        $beer = new Beer();
        $beer->setCode('xyz');
        $beer->setDescription("To jest opis");
        $beer->setHops("Opis chmieli");
        $beer->setMalts("Opis słodów");
        $beer->setName("Jasne Pełne");
        $beer->setTags(['nowe', 'polskie', 'IPA']);
        $beer->setIcon('https://raw.githubusercontent.com/marcinkazmierski/brewery-app/main/brewery/assets/images/poster_1.jpg');
        $beer->setBackgroundImage('https://raw.githubusercontent.com/marcinkazmierski/brewery-app/main/brewery/assets/images/bg1.png');

        $user->addUnlockedBeer($beer);

        $review = new Review();
        $review->setText("Bardzo dobre piwo!");
        $review->setBeer($beer);
        $review->setOwner($user);
        $review->setRating(4.5);

        $lockedBeer = new Beer();
        $lockedBeer->setCode('abc');
        $lockedBeer->setDescription("To jest opis Ciemne");
        $lockedBeer->setHops("Opis chmieli Ciemne");
        $lockedBeer->setMalts("Opis słodów Ciemne");
        $lockedBeer->setName("Ciemne Pyszne Piwo");
        $lockedBeer->setTags(['IPA']);
        $lockedBeer->setIcon('https://raw.githubusercontent.com/marcinkazmierski/brewery-app/main/brewery/assets/images/poster_1.jpg');
        $lockedBeer->setBackgroundImage('https://raw.githubusercontent.com/marcinkazmierski/brewery-app/main/brewery/assets/images/bg1.png');

        $manager->persist($lockedBeer);
        $manager->persist($beer);
        $manager->persist($user);
        $manager->persist($review);
        $manager->flush();
    }
}
