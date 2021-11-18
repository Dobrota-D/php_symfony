<?php

namespace App\Entity;

use App\Repository\TokenRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TokenRepository::class)
 */
class Token
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $token;

    /**
     * @ORM\ManyToOne(targetEntity=Tricount::class, inversedBy="tokens")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tricount_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getTricountId(): ?Tricount
    {
        return $this->tricount_id;
    }

    public function setTricountId(?Tricount $tricount_id): self
    {
        $this->tricount_id = $tricount_id;

        return $this;
    }
}
