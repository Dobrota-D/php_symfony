<?php

namespace App\Controller;

use App\Service\HandleGlobalPaymentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function index(): Response
    {
        $dataPayment = $this->dataPayment->paymentGraphicData();
        return $this->render('base.html.twig', [
            "data"=>$dataPayment,
        ]);
    }
}
