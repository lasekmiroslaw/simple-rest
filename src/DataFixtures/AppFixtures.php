<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Post;
use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setName('Janusz');
        $user->setSurname('Janusz');

        $password = $this->encoder->encodePassword($user, 'password');
        $user->setPassword($password);
        $user->setEmail('janusz@biedronka.pl');

        $manager->persist($user);

        for ($i = 0; $i < 10; $i++) {
            $post = new Post();
            $post->setTitle('blog post '.$i);
            $post->setDescription('blog post description...'.$i);
            $post->setUser($user);
            $manager->persist($post);

            $comment = new Comment();
            $comment->setComment('post comment'.$i);
            $comment->setUser($user);
            $comment->setPost($post);

            $manager->persist($comment);
        }

        $manager->flush();
    }
}
