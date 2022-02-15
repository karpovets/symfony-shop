<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use App\Entity\StaticStorage\OrderStaticStorage;
use App\Form\Admin\EditOrderFormType;
use App\Form\Handler\OrderFormHandler;
use App\Repository\OrderRepository;
use App\Utils\Manager\OrderManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/order', name: 'admin_order_')]
class OrderController extends AbstractController
{
    #[Route('/list', name: 'list')]
    public function list(OrderRepository $orderRepository): Response
    {
        $orders = $orderRepository->findBy(['isDeleted' => false], ['id' => 'DESC']);
        return $this->render('admin/order/list.html.twig', [
            'orders' => $orders,
            'orderStatusChoices' => OrderStaticStorage::getOrderStatusChoices(),
        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    #[Route('/add', name: 'add')]
    public function edit(Request $request, OrderFormHandler $orderFormHandler, Order $order = null): Response
    {
        if (!$order) {
            $order = new Order();
        }

        $form = $this->createForm(EditOrderFormType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $order = $orderFormHandler->processEditForm($order);

            $this->addFlash('success', 'Категория успешно сохранен');

            return $this->redirectToRoute('admin_order_edit', ['id'=> $order->getId()]);
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('warning', 'Ошибка сохранения, проверьте поля');
        }

        return $this->render('admin/order/edit.html.twig', [
            'order' => $order,
            'form' => $form->createView()
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Order $order, OrderManager $orderManager): Response
    {
        $orderManager->remove($order);

        $this->addFlash('warning', 'Заказ успешно удален');

        return $this->redirectToRoute('admin_щквук_list');
    }
}
