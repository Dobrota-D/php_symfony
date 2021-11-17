<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConnectController extends AbstractController
{
    /**
     * @Route("/login", name="connect")
     */
    /*
    public function index(): Response
    {
        return $this->render('connect/index.html.twig', [
            'controller_name' => 'Se connecter',
            'redirectTo'=>[
                'link'=>'sign',
                'front'=>'S\'inscrire'
            ],
        ]);
    }*/
    /**
     * @Route ("/signin", name="sign")
     */
    /*
    public function signIn(): Response
    {
        return $this->render('connect/index.html.twig', [
            'controller_name' => 'S\'inscrire',
            'redirectTo'=>[
                'link'=>"connect",
                'front'=>"Se connecter"
            ],
        ]);
    }*/
}
