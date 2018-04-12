<?php

namespace App\DataFixtures;

use App\Entity\Post;
use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\DataFixtures\UserFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PostFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user = $this->getReference(UserFixtures::USER_REFERENCE);

        $firstPost = new Post();
        $firstPost->setTitle('first post');
        $firstPost->setDescription('post description');
        $firstPost->setUser($user);
        $firstPost->setDate(new \Datetime('2018-11-11'));

        $manager->persist($firstPost);
        $this->setReference('post', $firstPost);

        for ($i = 0; $i < 10; $i++) {
            $post = new Post();
            $post->setTitle('blog post '.$i);
            $post->setDescription('blog post description...');
            $post->setUser($user);
            $post->setDate(new \Datetime('2018-01-'.$i));
            $manager->persist($post);

            $comment1 = new Comment();
            $comment1->setComment('post comment');
            $comment1->setUser($user);
            $comment1->setPost($post);

            $comment2 = new Comment();
            $comment2->setComment('second post comment');
            $comment2->setUser($user);
            $comment2->setPost($post);

            $comment3 = new Comment();
            $comment3->setComment('third post comment');
            $comment3->setUser($user);
            $comment3->setPost($post);

            $manager->persist($comment1);
            $manager->persist($comment2);
            $manager->persist($comment3);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
        );
    }
}
