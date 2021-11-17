<?php

namespace App\Controller;

use App\Form\TricountType;
use App\Entity\Tricount;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TricountController extends AbstractController
{
    /**
     * @Route("", name="tricount")
     */
    public function index(Request $request): Response
    {
        $Tricount = new Tricount();
        $form = $this->createForm(TricountType::class, $Tricount);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($Tricount);
            $entityManager->flush();

            return $this->redirection("add_participant", [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('tricount/index.html.twig', [
            'Tricount' => $form->createView(),
        ]);
    }
}
