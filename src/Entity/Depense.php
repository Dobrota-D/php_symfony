<?php

namespace App\Entity;

use App\Repository\DepenseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DepenseRepository::class)
 */
class Depense
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Participant::class, inversedBy="pay_master_part", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $pay_master;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    /**
     * @ORM\Column(type="float")
     */
    private $amount_total;

    /**
     * @ORM\ManyToOne(targetEntity=Tricount::class, inversedBy="depenses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tricount;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPayMaster(): ?Participant
    {
        return $this->pay_master;
    }

    public function setPayMaster(Participant $pay_master): self
    {
        $this->pay_master = $pay_master;

        return $this;
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getAmountTotal(): ?float
    {
        return $this->amount_total;
    }

    public function setAmountTotal(float $amount_total): self
    {
        $this->amount_total = $amount_total;

        return $this;
    }

    public function getTricount(): ?Tricount
    {
        return $this->tricount;
    }

    public function setTricount(?Tricount $tricount): self
    {
        $this->tricount = $tricount;

        return $this;
    }
}
