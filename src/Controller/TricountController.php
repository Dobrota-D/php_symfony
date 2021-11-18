<?php

namespace App\Controller;

use App\Form\TricountType;
use App\Entity\Tricount;
use App\Repository\ParticipantRepository;
use App\Service\TricountService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class TricountController extends AbstractController
{

    /**
     * ALL ALLOWED DEVISES
     */
    private const DEVISES = ['EUR', 'USD', 'CHF'];

    /**
     * @var TricountService
     */
    private TricountService $tricountService;

    /**
     * Create new TricountController instance.
     *
     * TricountController constructor.
     * @param TricountService $tricountService
     */
    public function __construct(TricountService $tricountService)
    {
        $this->tricountService = $tricountService;
    }

    /**
     * @Route("/tricount", name="tricount")
     */
    public function index(Request $request): Response
    {

        # We check if the User if authenticated
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            # redirect to the User page if not
            return $this->redirectToRoute('app_register');
        }

        $tricount = new Tricount();

        # Get the authenticated User's informations
        $user = $this->getUser();

        $form = $this->createForm(TricountType::class, $tricount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if (!in_array($form->getData()->getDevise(), self::DEVISES)) {
                return $this->redirectToRoute('tricount');
            }
            $this->tricountService->createTricount($tricount, $user);
            # After submit redirect to the same page, so the form is reset
            $this->redirect($request->getUri());
        }
        return $this->render('tricount/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route ("/tricount/{id}", name="show", methods={"GET"})
     */
    public function tricountIndex(ParticipantRepository $participantRepository, Tricount $tricount): Response{
        $triCount_participant = $participantRepository->findBy(["personindebt_id"=>$tricount]);
        return $this->render('tricount/showParticipant.html.twig', [
            "participants"=>$triCount_participant
        ]);
    }
}
