<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RotaController extends AbstractController
{
    /**
     * @Route("/rota", name="rota")
     */
    public function index()
    {
        return $this->render('rota/index.html.twig', [
            'controller_name' => 'RotaController',
        ]);
    }

    /**
     * @Route("/rota", methods={"POST"}, name="getRota")
     */
    public function getRota(): Response
    {
        return new Response(json_encode(['data' => ['test' => 'value']]), Response::HTTP_OK);
    }
}
