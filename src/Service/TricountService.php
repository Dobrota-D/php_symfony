<?php

namespace App\Service;

use App\Entity\Participant;
use App\Entity\Tricount;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class TricountService
{


    private EntityManagerInterface $entityManager;

    /**
     * Create a new TricountService instance.
     *
     * TricountService constructor.
     */
    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    /**
     * Create a new Tricount
     *
     * @param Tricount $tricount
     * @return void
     */
    public function createTricount(Tricount $tricount, UserInterface $user_id): void
    {
        # Manage tricount
        $this->entityManager->getRepository(Tricount::class);
        $this->entityManager->persist($tricount);
        $this->entityManager->flush();


        # Manage Participants
        $participant = new Participant();

        # Set the authenticated user ID
        $participant->setUser($user_id);

        # Set the created Tricount ID
        $participant->setTricountId($tricount);

        $this->entityManager->getRepository(Participant::class);
        $this->entityManager->persist($participant);
        $this->entityManager->flush();
    }
}
