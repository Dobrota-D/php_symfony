<?php

namespace App\Controller;

use App\Service\HandleGlobalPaymentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    private $dataPayment;
    public function __construct(HandleGlobalPaymentService $dataPayment)
    {
        $this->dataPayment = $dataPayment;
    }

    /**
     * @Route("/", name="default")
     */
    public function index(Request $request): Response
    {
        $invitation_link = $request->server->get('SERVER_NAME') . $this->generateUrl('tricount_add_participant', array('token' => 'HVCG3Q80mnS2hc8thqsDPMBLUpcmir2JbvaZL12Vwqs'));

        dump($request->server);
        return $this->render('home.html.twig', [
            'invitation_link' => $invitation_link
        ]);
    }
}
