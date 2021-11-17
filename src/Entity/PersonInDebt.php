<?php

namespace App\Entity;

use App\Repository\PersonInDebtRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PersonInDebtRepository::class)
 */
class PersonInDebt
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Participant::class, inversedBy="tricount")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_participant;

    /**
     * @ORM\ManyToOne(targetEntity=Tricount::class, inversedBy="personInDebts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tricount;

    /**
     * @ORM\OneToOne(targetEntity=Depense::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $depense;

    /**
     * @ORM\Column(type="float")
     */
    private $amount_personnal;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdParticipant(): ?Participant
    {
        return $this->id_participant;
    }

    public function setIdParticipant(?Participant $id_participant): self
    {
        $this->id_participant = $id_participant;

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

    public function getDepense(): ?Depense
    {
        return $this->depense;
    }

    public function setDepense(Depense $depense): self
    {
        $this->depense = $depense;

        return $this;
    }

    public function getAmountPersonnal(): ?float
    {
        return $this->amount_personnal;
    }

    public function setAmountPersonnal(float $amount_personnal): self
    {
        $this->amount_personnal = $amount_personnal;

        return $this;
    }
}
