<?php

namespace App\Service;

use App\Entity\Participant;
use App\Entity\Tricount;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class TricountService
{

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @var TokenService
     */
    private TokenService $tokenService;

    /**
     * Create a new TricountService instance.
     *
     * TricountService constructor.
     */
    public function __construct(EntityManagerInterface $entityManager, TokenService $tokenService)
    {
        $this->entityManager = $entityManager;
        $this->tokenService = $tokenService;
    }

    /**
     * Create a new Tricount
     *
     * @param Tricount $tricount
     * @param UserInterface $user_id
     * @return void
     * @throws \Exception
     */
    public function createTricount(Tricount $tricount, UserInterface $user_id): void
    {
        # Manage tricount
        $this->entityManager->getRepository(Tricount::class);
        $this->entityManager->persist($tricount);
        $this->entityManager->flush();

        # add created Tricount ID to Token
        $this->tokenService->createTricountToken($tricount);

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
