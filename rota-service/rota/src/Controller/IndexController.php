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
use Symfony\Component\Form\FormInterface;
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
            $this->handleRequest($rotaForm, $request, 'rota');
            $this->handleRequest($staffForm, $request, 'staff');
            $this->handleRequest($shiftForm, $request, 'shift');
            $this->handleRequest($shopForm, $request, 'shop');
        }

        return $this->render('index/index.html.twig', [
            'shopForm' => $shopForm->createView(),
            'rotaForm' => $rotaForm->createView(),
            'staffForm' => $staffForm->createView(),
            'shiftForm' => $shiftForm->createView()
        ]);
    }

    private function handleRequest(FormInterface $form, Request $request, $key): void
    {
        if (!$request->request->has($key)) {
            return;
        }

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $shift = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($shift);
            $entityManager->flush();
        }
    }
}
