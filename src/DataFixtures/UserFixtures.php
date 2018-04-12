<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserFixtures extends Fixture implements ContainerAwareInterface
{
    public const USER_REFERENCE = 'user';
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setName('Janusz');
        $user->setSurname('Janusz');

        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($user, 'password');
        $user->setPassword($password);
        $user->setEmail('janusz@biedronka.pl');

        $manager->persist($user);
        $manager->flush();

        // other fixtures can get this object using the UserFixtures::USER_REFERENCE constant
        $this->addReference(self::USER_REFERENCE, $user);
    }
}
