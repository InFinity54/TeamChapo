<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nickname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $picture = "default.jpg";

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $roles = "";

    /**
     * @ORM\ManyToOne(targetEntity=Lane::class, inversedBy="user")
     */
    private $lane;

    /**
     * @ORM\OneToOne(targetEntity=Pool::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $pool;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $riotPuuid;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $riotAccountId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $riotId;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActivated;

    /**
     * @ORM\Column(type="datetime")
     */
    private $registerAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $lastUpdateAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $token;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $tokenExpDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): self
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): ?array
    {
        return explode("|", $this->roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = implode("|", $roles);

        return $this;
    }

    public function getLane(): ?Lane
    {
        return $this->lane;
    }

    public function setLane(?Lane $lane): self
    {
        $this->lane = $lane;

        return $this;
    }

    public function getPool(): ?Pool
    {
        return $this->pool;
    }

    public function setPool(Pool $pool): self
    {
        // set the owning side of the relation if necessary
        if ($pool->getUser() !== $this) {
            $pool->setUser($this);
        }

        $this->pool = $pool;

        return $this;
    }

    public function getRiotPuuid(): ?string
    {
        return $this->riotPuuid;
    }

    public function setRiotPuuid(?string $riotPuuid): self
    {
        $this->riotPuuid = $riotPuuid;

        return $this;
    }

    public function getRiotAccountId(): ?string
    {
        return $this->riotAccountId;
    }

    public function setRiotAccountId(?string $riotAccountId): self
    {
        $this->riotAccountId = $riotAccountId;

        return $this;
    }

    public function getRiotId(): ?string
    {
        return $this->riotId;
    }

    public function setRiotId(?string $riotId): self
    {
        $this->riotId = $riotId;

        return $this;
    }

    public function getIsActivated(): ?bool
    {
        return $this->isActivated;
    }

    public function setIsActivated(bool $isActivated): self
    {
        $this->isActivated = $isActivated;

        return $this;
    }

    public function getRegisterAt(): ?\DateTimeInterface
    {
        return $this->registerAt;
    }

    public function setRegisterAt(\DateTimeInterface $registerAt): self
    {
        $this->registerAt = $registerAt;

        return $this;
    }

    public function getLastUpdateAt(): ?\DateTimeInterface
    {
        return $this->lastUpdateAt;
    }

    public function setLastUpdateAt(\DateTimeInterface $lastUpdateAt): self
    {
        $this->lastUpdateAt = $lastUpdateAt;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getTokenExpDate(): ?\DateTimeInterface
    {
        return $this->tokenExpDate;
    }

    public function setTokenExpDate(?\DateTimeInterface $tokenExpDate): self
    {
        $this->tokenExpDate = $tokenExpDate;

        return $this;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     * This can return null if the password was not encoded using a salt.
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Returns the username used to authenticate the user.
     * @return string The username
     */
    public function getUsername()
    {
        return $this->getNickname();
    }

    /**
     * Removes sensitive data from the user.
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
}
