<?php

namespace App\Controller;

use App\Entity\Rota;
use App\Service\MannedTime\Calculator;;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RotaController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/rota/{rota}/singlemannedtime", methods={"GET"}, name="getSingleMannedMinutes")
     */
    public function getSingleMannedTime(Rota $rota): Response
    {
        $singleMannedTime = new Calculator($rota, $this->entityManager);
        return new Response(json_encode(['data' => $singleMannedTime->getSingleManning()]), Response::HTTP_OK);
    }
}
