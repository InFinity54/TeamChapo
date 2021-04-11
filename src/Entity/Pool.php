<?php

namespace App\Entity;

use App\Repository\PoolRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PoolRepository::class)
 */
class Pool
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="pool", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity=Champion::class)
     * @ORM\JoinTable(name="pool_primary")
     */
    private $primaryPool;

    /**
     * @ORM\ManyToMany(targetEntity=Champion::class)
     * @ORM\JoinTable(name="pool_secondary")
     */
    private $secondaryPool;

    /**
     * @ORM\ManyToMany(targetEntity=Champion::class)
     * @ORM\JoinTable(name="pool_excluded")
     */
    private $excludedPool;

    public function __construct()
    {
        $this->primaryPool = new ArrayCollection();
        $this->secondaryPool = new ArrayCollection();
        $this->excludedPool = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Champion[]
     */
    public function getPrimaryPool(): Collection
    {
        return $this->primaryPool;
    }

    public function addPrimaryPool(Champion $primaryPool): self
    {
        if (!$this->primaryPool->contains($primaryPool)) {
            $this->primaryPool[] = $primaryPool;
        }

        return $this;
    }

    public function removePrimaryPool(Champion $primaryPool): self
    {
        $this->primaryPool->removeElement($primaryPool);

        return $this;
    }

    /**
     * @return Collection|Champion[]
     */
    public function getSecondaryPool(): Collection
    {
        return $this->secondaryPool;
    }

    public function addSecondaryPool(Champion $secondaryPool): self
    {
        if (!$this->secondaryPool->contains($secondaryPool)) {
            $this->secondaryPool[] = $secondaryPool;
        }

        return $this;
    }

    public function removeSecondaryPool(Champion $secondaryPool): self
    {
        $this->secondaryPool->removeElement($secondaryPool);

        return $this;
    }

    /**
     * @return Collection|Champion[]
     */
    public function getExcludedPool(): Collection
    {
        return $this->excludedPool;
    }

    public function addExcludedPool(Champion $excludedPool): self
    {
        if (!$this->excludedPool->contains($excludedPool)) {
            $this->excludedPool[] = $excludedPool;
        }

        return $this;
    }

    public function removeExcludedPool(Champion $excludedPool): self
    {
        $this->excludedPool->removeElement($excludedPool);

        return $this;
    }
}
