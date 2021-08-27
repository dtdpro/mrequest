<?php

namespace App\Entity;

use App\Repository\BinRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BinRepository::class)
 */
class Bin implements \JsonSerializable
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
    private $ExtId;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $CreatedAt;

    /**
     * @ORM\OneToMany(targetEntity=BinEntry::class, mappedBy="bin")
     * @ORM\OrderBy({"CreatedAt"="DESC"})
     */
    private $binEntries;

    public function __construct()
    {
        $this->binEntries = new ArrayCollection();
        $this->setCreatedAt(new \DateTimeImmutable());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExtId(): ?string
    {
        return $this->ExtId;
    }

    public function setExtId(string $ExtId): self
    {
        $this->ExtId = $ExtId;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(\DateTimeImmutable $CreatedAt): self
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }

    /**
     * @return Collection|BinEntry[]
     */
    public function getBinEntries(): Collection
    {
        return $this->binEntries;
    }

    public function addBinEntry(BinEntry $binEntry): self
    {
        if (!$this->binEntries->contains($binEntry)) {
            $this->binEntries[] = $binEntry;
            $binEntry->setBin($this);
        }

        return $this;
    }

    public function removeBinEntry(BinEntry $binEntry): self
    {
        if ($this->binEntries->removeElement($binEntry)) {
            // set the owning side to null (unless already changed)
            if ($binEntry->getBin() === $this) {
                $binEntry->setBin(null);
            }
        }

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            "extId" =>$this->getExtId(),
            "entries" =>$this->getBinEntries()
        ];
    }
}
