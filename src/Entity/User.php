<?php


namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="users")
 */
class User implements UserInterface
{

    public function __construct()
    {
        $this->createdAt = new DateTime('now');
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @var Review[]|null
     * @ORM\OneToMany(targetEntity="App\Entity\Review", mappedBy="user", cascade={"persist", "remove"})
     */
    private $reviews;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\Length(min=6, minMessage="Пароль слишком короткий")
     */
    private $plainPassword;

    /**
     * @var string|null
     */
    private $retypedPassword;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
     */
    private  $createdAt;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Review[]|null
     */
    public function getReviews(): ?array
    {
        return $this->reviews;
    }

    /**
     * @param Review[]|null $reviews
     * @return User
     */
    public function setReviews(?array $reviews): self
    {
        $this->reviews = $reviews;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }



    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return User
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     * @return array
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        return array_unique($roles);
    }

    /**
     * @param array $roles
     * @return User
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }


    /**
     * @return string|null The encoded password if any
     */
    public function getPassword() : ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): self
    {
        $this->plainPassword = $password;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getRetypedPassword() : ?string
    {
        return $this->retypedPassword;
    }

    /**
     * @param string $retypedPassword
     */
    public function setRetypedPassword(string $retypedPassword): void
    {
        $this->retypedPassword = $retypedPassword;
    }

    /**
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }


    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
}