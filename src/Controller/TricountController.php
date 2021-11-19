<?php

namespace App\Controller;

use App\Entity\Depense;
use App\Entity\Participant;
use App\Entity\Users;
use App\Form\ExpensesType;
use App\Form\RegistrationFormType;
use App\Form\TricountType;
use App\Entity\Tricount;
use App\Form\UsersFormType;
use App\Repository\ParticipantRepository;
use App\Repository\TokenRepository;
use App\Service\TricountService;
use Cassandra\Type\UserType;
use Exception;
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

    private TokenRepository $tokenRepository;

    /**
     * Create new TricountController instance.
     *
     * TricountController constructor.
     * @param TricountService $tricountService
     */
    public function __construct(TricountService $tricountService, TokenRepository $tokenRepository)
    {
        $this->tricountService = $tricountService;
        $this->tokenRepository = $tokenRepository;
    }

    /**
     * @Route("/tricount", name="tricount")
     * @throws Exception
     */
    public function index(Request $request): Response
    {

        # We check if the User is authenticated
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            # redirect to the login page if user is not authenticated
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
     * @Route("/tricount/add/participant/{token}", name="tricount_add_participant")
     */
    public function addParticipant(Request $request): Response
    {
        $form = $this->createForm(UsersFormType::class);
        $form->add('nom');
        $form->handleRequest($request);

        if (count($this->tokenRepository->findByToken($request->attributes->get('token'))) >= 1) {

            if ($form->isSubmitted() && $form->isValid()) {
                $participant = new Participant();
                $tricount_id = $this->tokenRepository->findTokenRelatedTricount($request->attributes->get('token'))[0]->getTricountId();

                $entityManager = $this->getDoctrine()->getManager();

                $user = $this->tricountService->createSimpleUserGuest($form->getData()->getNom());

                $participant->setUser($user);
                $participant->setTricountId($tricount_id);
                $entityManager->persist($participant);
                $entityManager->flush();
            }


           # dump($user);
        } else {
            return $this->redirectToRoute('default');
        }


        return $this->render('tricount/add_participant.html.twig', [
            'form' => $form->createView()
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

    /**
     * @Route ("/tricount/{id}/add/expense", name="Depence")
     */
    public function addExpenses(Request $request): Response
    {
        $depenses = new Depense();

        $form = $this->createForm(ExpensesType::class, $depenses);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if (!in_array($form->getData()->getDevise(), self::DEVISES)) {
                return $this->redirectToRoute('tricount');
            }
            #$this->tricountService->createTricount($tricount, $user);
            # After submit redirect to the same page, so the form is reset

        }
        return $this->render('tricount/add_depense.html.twig', [
            'form' => $form->createView(),
        ]);





    }
}
