<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Product;
use App\Form\OrderType;
use App\Managers\OrderManager;
use App\Services\PlacetoPay\PaymentRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{

    /**
     * @var OrderManager
     */
    private $orderManager;

    /**
     * Constructor.
     * @param OrderManager $orderManager
     */
    public function __construct(OrderManager $orderManager)
    {
        $this->orderManager = $orderManager;
    }

    /**
     * Action that creates a new pre order.
     * @param int $productId
     * @param Request $request
     * @Route("/order/new/product/{productId}", name="new_order", methods={"GET"})
     * @return Response
     */
    public function new(int $productId, Request $request)
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->find($productId);
        $quantity = (int) $request->get('q', 1);

        if (!$product) {
            throw $this->createNotFoundException('El producto no existe!');
        }
        // create a new order
        $order = $this->orderManager->generatePreOrder($product, $quantity);
        // create order form
        $form = $this->createForm(OrderType::class, $order);

        return $this->render('order/new.html.twig', [
            'order' => $order,
            'detail' => $order->getDetails()->first(),
            'form' => $form->createView()
        ]);
    }

    /**
     * Action that creates an order.
     * @param Request $request
     * @Route("/order/create", name="create_order", methods={"POST"})
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function create(Request $request)
    {
        // create order form
        $form = $this->createForm(OrderType::class, new Order());
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $order = $form->getData();
            $this->orderManager->createOrder($order);
            return $this->redirectToRoute('show_order', [
                'urlCode' => $order->getUrlCode()
            ]);
        }

        return $this->render('order/new.html.twig', [
            'order' => $form->getData(),
            'detail' => $form->getData()->getDetails()->first(),
            'form' => $form->createView()
        ]);

    }

    /**
     * Action that shows an order.
     * @param string $urlCode
     * @Route("/order/{urlCode}/show", name="show_order", methods={"GET"})
     * @return Response
     */
    public function show(string $urlCode)
    {
        $order = $this->orderManager->getOrderByUrlCode($urlCode);

        if (!$order) {
            throw $this->createNotFoundException('La orden no existe!');
        }

        return $this->render('order/show.html.twig', [
            'order' => $order,
            'detail' => $order->getDetails()->first()
        ]);
    }

    /**
     * @Route("/order/{urlCode}/status", name="status_order")
     * @param string $urlCode
     */
    public function status(string $urlCode)
    {
        dd('estado orden');
    }

    /**
     * @param PaymentRequest $paymentRequest
     * @param string $urlCode
     * @Route("/order/{urlCode}/pay", name="status_pay")
     */
    public function pay(PaymentRequest $paymentRequest, string $urlCode)
    {
        $paymentRequest->testRequest($urlCode);
    }
}
