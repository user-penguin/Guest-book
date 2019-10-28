<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReviewRepository")
 */
class Review
{
    public function __construct()
    {
        $this->createdAt = new DateTime('now');
        $this->updatedAt = new DateTime('now');
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Event|null
     * @ORM\ManyToOne(targetEntity="App\Entity\Event", inversedBy="reviews")
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
     */
    private $event;

    /**
     * @var User|null
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="reviews")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $rate;

    /**
     * @ORM\Column(type="string", length=10000)
     */
    private $text;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Event|null
     */
    public function getEvent(): ?Event
    {
        return $this->event;
    }

    /**
     * @param Event|null $event
     * @return Review
     */
    public function setEvent(?Event $event): self
    {
        $this->event = $event;
        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     * @return Review
     */
    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }



    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getRate(): ?int
    {
        return $this->rate;
    }

    public function setRate(int $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }
}
