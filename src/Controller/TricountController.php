<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\TricountType;
use App\Entity\Tricount;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TricountController extends AbstractController
{

    private const DEVISES = ['EUR', 'USD', 'CHF'];

    /**
     * @Route("", name="tricount")
     */
    public function index(Request $request): Response
    {
       $tricount = new Tricount();

       $form = $this->createForm(TricountType::class, $tricount);
       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid()) {

           if (!in_array($form->getData()->getDevise(), self::DEVISES)) {
               return $this->redirectToRoute('tricount');
           }

           if ($form->getData()->getTitle() < 3) {
               return $this->redirectToRoute('tricount');
           }

           $entityManager = $this->getDoctrine()->getManager();
           $entityManager->persist($tricount);
           $entityManager->flush();

       }
        return $this->render('tricount/index.html.twig', [
            'form' => $form->createView(),
            'devises' => self::DEVISES
        ]);
    }
}
