<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function findPosts()
    {
      return $this->getEntityManager()->createQuery(
          'SELECT p.title, p.description, p.date, u.name, u.surname
          FROM App\Entity\Post p
          JOIN p.user u
          WITH p.user = u.id
          ORDER BY p.date DESC'
      )
      ->getResult();
    }
}
