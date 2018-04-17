<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public const USER_REFERENCE = 'user';

    public function load(ObjectManager $manager)
    {
        $user = new User();

        $user->setName('Janusz');
        $user->setSurname('Janusz');
        $user->setPlainPassword('password50');
        $user->setEmail('janusz@biedronka.pl');

        $manager->persist($user);
        $manager->flush();

        // other fixtures can get this object using the UserFixtures::USER_REFERENCE constant
        $this->addReference(self::USER_REFERENCE, $user);
    }
}
