<?php

namespace App\Entity;

use App\Repository\ParticipantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParticipantRepository::class)
 */
class Participant
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Tricount::class, inversedBy="participants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tricount_id;


    /**
     * @ORM\OneToOne(targetEntity=Depense::class, mappedBy="pay_master", cascade={"persist", "remove"})
     */
    private $pay_master_part;

    /**
     * @ORM\ManyToMany(targetEntity=Users::class, inversedBy="participants")
     */
    private $user;

    public function __construct()
    {
        $this->user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPersonInDebtId(): ?Tricount
    {
        return $this->personindebt_id;
    }

    public function setPersonInDebtId(?Tricount $personindebt_id): self
    {
        $this->personindebt_id = $personindebt_id;

        return $this;
    }

    public function getPayMasterPart(): ?Depense
    {
        return $this->pay_master_part;
    }

    public function setPayMasterPart(Depense $pay_master_part): self
    {
        // set the owning side of the relation if necessary
        if ($pay_master_part->getPayMaster() !== $this) {
            $pay_master_part->setPayMaster($this);
        }

        $this->pay_master_part = $pay_master_part;

        return $this;
    }

    /**
     * @return Collection|Users[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(Users $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
        }

        return $this;
    }

    public function removeUser(Users $user): self
    {
        $this->user->removeElement($user);

        return $this;
    }
}
