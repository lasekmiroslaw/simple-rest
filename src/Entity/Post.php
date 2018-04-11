<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 */
class Post
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id")
     */
    private $userId;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Please enter a title")
     * @Assert\Type("string")
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Please enter a description")
     * @Assert\Type("string")
     */
    private $description;

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

    public function getUserId(): User
    {
        return $this->userId;
    }

    public function setUserId(User $user)
    {
        $this->userId = $user;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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
