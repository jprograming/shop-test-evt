<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\PlacetoPayIntegration;
use App\Entity\Product;
use App\Form\OrderType;
use App\Managers\OrderManager;
use App\Services\PlacetoPay\PaymentRequest;
use App\Services\PlacetoPay\RequestInformation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Exception\LogicException;

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
        $quantity = abs((int) $request->get('q', 1));

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
                'code' => $order->getCode()
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
     * @param string $code
     * @Route("/order/{code}/show", name="show_order", methods={"GET"})
     * @return Response
     */
    public function show(string $code)
    {
        $order = $this->orderManager->getOrderByCode($code);

        if (!$order) {
            throw $this->createNotFoundException('La orden no existe!');
        }

        return $this->render('order/show.html.twig', [
            'order' => $order,
            'detail' => $order->getDetails()->first()
        ]);
    }

    /**
     * @param PaymentRequest $paymentRequest
     * @param string $code
     * @Route("/order/{code}/pay", name="request_pay_order")
     * @return Response
     * @throws \Dnetix\Redirection\Exceptions\PlacetoPayException
     */
    public function pay(PaymentRequest $paymentRequest, string $code)
    {
        $order = $this->orderManager->getOrderByCode($code);

        if (!$order) {
            throw $this->createNotFoundException('La orden no existe!');
        }

        try {
            $redirect = $paymentRequest->sendPaymentRequest($order);
            return $this->redirect($redirect);
        } catch (LogicException $exception) {
            return $this->render('order/payment_request_error.html.twig', [
                'error' => $exception->getMessage()
            ]);
        }
    }

    /**
     * @param RequestInformation $requestInformation
     * @param string $code
     * @Route("/order/{code}/status", name="response_pay_order")
     * @return Response
     */
    public function status(RequestInformation $requestInformation, string $code)
    {
        $order = $this->orderManager->getOrderByCode($code);

        if (!$order) {
            throw $this->createNotFoundException('La orden no existe!');
        }

        try {
            // get integration record
            $ppIntegration = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository(PlacetoPayIntegration::class)->getRecordByOrder($order)
            ;
            $requestInformation->process($ppIntegration->getRequestId(), $order);
            return $this->render('order/status.html.twig', [
                'order' => $order
            ]);

        } catch (LogicException $exception) {
            return $this->render('order/payment_response_error.html.twig', [
                'order' => $order
            ]);
        }
    }
}
