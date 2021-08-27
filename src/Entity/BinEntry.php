<?php

namespace App\Entity;

use App\Repository\BinEntryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BinEntryRepository::class)
 */
class BinEntry implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Bin::class, inversedBy="binEntries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bin;

    /**
     * @ORM\Column(type="json")
     */
    private $EntryHeaders;

    /**
     * @ORM\Column(type="text")
     */
    private $EntryBody;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $CreatedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $EntryMethod;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTimeImmutable());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBin(): ?Bin
    {
        return $this->bin;
    }

    public function setBin(?Bin $bin): self
    {
        $this->bin = $bin;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEntryHeaders()
    {
        return $this->EntryHeaders;
    }

    /**
     * @param mixed $EntryHeaders
     */
    public function setEntryHeaders($EntryHeaders): void
    {
        $this->EntryHeaders = $EntryHeaders;
    }

    public function getEntryBody(): ?string
    {
        return $this->EntryBody;
    }

    public function setEntryBody(string $EntryBody): self
    {
        $this->EntryBody = $EntryBody;

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

    public function jsonSerialize()
    {
        return [
            'created' => $this->getCreatedAt()->format("Y-m-d H:i:s"),
            'headers' => $this->getEntryHeaders(),
            'body' => $this->getEntryBody()
        ];
    }

    public function getEntryMethod(): ?string
    {
        return $this->EntryMethod;
    }

    public function setEntryMethod(?string $EntryMethod): self
    {
        $this->EntryMethod = $EntryMethod;

        return $this;
    }
}
