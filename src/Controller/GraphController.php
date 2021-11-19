<?php

namespace App\Controller;

use App\Service\HandleGlobalPaymentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GraphController extends AbstractController
{
    private $dataPayment;
    public function __construct(HandleGlobalPaymentService $dataPayment)
    {
        $this->dataPayment = $dataPayment;
    }

    /**
     * @Route("/graph", name="graph")
     */
    public function index(): Response
    {
        $data = $this->dataPayment->paymentGraphicData();
        return $this->render('graph/index.html.twig', [
            'controller_name' => 'GraphController',
            'data' => $data
        ]);
    }

}
