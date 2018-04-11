<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Post")
     * @ORM\JoinColumn(name="postId", referencedColumnName="id")
     */
    private $postId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id")
     */
    private $userId;

    /**
     * @ORM\Column(type="text")
     */
    private $comment;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    public function __construct()
    {
        $this->date = new \DateTime();
    }    

    public function getId()
    {
        return $this->id;
    }

    public function getPostId(): Post
    {
        return $this->postId;
    }

    public function setPostId(Post $post): self
    {
        $this->postId = $post;
    }

    public function getUserId(): User
    {
        return $this->userId;
    }

    public function setUserId(User $user)
    {
        $this->userId = $user;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
