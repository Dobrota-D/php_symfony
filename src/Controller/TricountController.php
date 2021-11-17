<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\TricountType;
use App\Entity\Tricount;
use App\Repository\ParticipantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/tricount", name="tricount")
 */
class TricountController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(Request $request): Response
    {
        $tricount = new Tricount();
        $form = $this->createForm(TricountType::class, $tricount);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tricount);
            $entityManager->flush();

            return $this->redirectToRoute("show", ["id"=>$tricount["id"]], Response::HTTP_SEE_OTHER);
        }
        return $this->render('tricount/index.html.twig', [
            'Tricount' => $form->createView(),
        ]);
    }

    /**
     * @Route ("/{id}", name="show", methods={"GET"})
     */
    public function tricountIndex(ParticipantRepository $participantRepository, Tricount $tricount): Response{
        $triCount_participant = $participantRepository->findBy(["personindebt_id"=>$tricount]);
        return $this->render('tricount/showParticipant.html.twig', [
            "participants"=>$triCount_participant
        ]);
    }
}
