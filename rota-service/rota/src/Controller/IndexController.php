<?php

namespace App\Controller;

use App\Entity\Rota;
use App\Entity\Shift;
use App\Entity\Shop;
use App\Entity\Staff;
use App\Form\RotaType;
use App\Form\ShiftType;
use App\Form\ShopType;
use App\Form\StaffType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(Request $request)
    {
        $shop = new Shop();
        $rota = new Rota();
        $staff = new Staff();
        $shift = new Shift();

        $shopForm = $this->createForm(ShopType::class, $shop);
        $rotaForm = $this->createForm(RotaType::class, $rota);
        $shiftForm = $this->createForm(ShiftType::class, $shift);
        $staffForm = $this->createForm(StaffType::class, $staff);

        if ($request->getMethod() === 'POST') {
            if ($request->request->has('rota')) {
                $rotaForm->handleRequest($request);
                if ($rotaForm->isSubmitted() && $rotaForm->isValid()) {
                    $rota = $rotaForm->getData();
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($rota);
                    $entityManager->flush();
                }
            }

            if ($request->request->has('staff')) {
                $staffForm->handleRequest($request);
                if ($staffForm->isSubmitted() && $staffForm->isValid()) {
                    $staff = $staffForm->getData();
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($staff);
                    $entityManager->flush();
                }
            }

            if ($request->request->has('shift')) {
                $shiftForm->handleRequest($request);
                if ($shiftForm->isSubmitted() && $shiftForm->isValid()) {
                    $shift = $shiftForm->getData();
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($shift);
                    $entityManager->flush();
                }
            }

            if ($request->request->has('shop')) {
                $shopForm->handleRequest($request);
                if ($shopForm->isSubmitted() && $shopForm->isValid()) {
                    $shop = $shopForm->getData();
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($shop);
                    $entityManager->flush();
                }
            }

        }

        $result = $this->render('index/mannedhours.html.twig', [
            'monday' => 1,
            'tuesday' => 1,
            'wednesday' => 1,
            'thursday' => 1,
            'friday' => 1,
            'saturday' => 1,
            'sunday' => 1,
            'total' => 1
        ]);

        return $this->render('index/index.html.twig', [
            'shopForm' => $shopForm->createView(),
            'rotaForm' => $rotaForm->createView(),
            'staffForm' => $staffForm->createView(),
            'shiftForm' => $shiftForm->createView(),
            'result' => $result
        ]);
    }
}
