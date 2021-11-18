<?php

namespace App\Service;

use App\Entity\Tricount;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class TricountService
{

    /**
     * ALL ALLOWED DEVISES
     */
    private const DEVISES = ['EUR', 'USD', 'CHF'];

    private EntityManagerInterface $entityManager;

    private RouterInterface $router;

    /**
     * Create a new TricountService instance.
     *
     * TricountService constructor.
     */
    public function __construct(EntityManagerInterface $entityManager, RouterInterface $router) {
        $this->entityManager = $entityManager;
        $this->router = $router;
    }

    /**
     * Create a new Tricount
     *
     * @param Tricount $tricount
     * @return void
     */
    public function createTricount(Tricount $tricount): void
    {
        $this->entityManager->getRepository(Tricount::class);
        $this->entityManager->persist($tricount);
        $this->entityManager->flush();
    }
}
