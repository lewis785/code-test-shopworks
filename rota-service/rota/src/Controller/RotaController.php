<?php

namespace App\Controller;

use App\Entity\Rota;
use App\Entity\Shift;
use App\Repository\RotaRepository;
use App\Repository\ShiftRepository;
use App\Service\MannedTime\Calculator;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RotaController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private ShiftRepository $shiftRepository;
    private RotaRepository $rotaRepository;

    public function __construct(RotaRepository $rotaRepository, ShiftRepository $shiftRepository, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->rotaRepository = $rotaRepository;
        $this->shiftRepository = $shiftRepository;
    }

    /**
     * @Route("/rota/{rota}/shift", methods={"GET"}, name="getRotaShifts")
     * @param Rota $rota
     *
     * @return Response
     */
    public function getRotaShifts(Rota $rota): Response
    {
        $shifts = $this->entityManager->getRepository(Shift::class)->findBy(['rota' => $rota]);
        return new Response(json_encode(['data' => $shifts]), Response::HTTP_OK);
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
