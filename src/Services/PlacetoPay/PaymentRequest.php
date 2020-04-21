<?php

namespace App\Services\PlacetoPay;
use App\Entity\Customer;
use App\Entity\Order;
use App\Managers\PlacetoPayIntegrationManager;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Validator\Exception\LogicException;

/**
 * Class that handle the payment request to PlacetoPay plataform.
 * @package App\Services\PlacetoPay
 */
class PaymentRequest extends AbstractRequest
{

    /**
     * @var PlacetoPayIntegrationManager
     */
    private $ppIntegrationManager;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * Constructor.
     * @param InstanceConfiguration $instance
     * @param PlacetoPayIntegrationManager $ppIntegrationManager
     * @param RouterInterface $router
     * @throws \Dnetix\Redirection\Exceptions\PlacetoPayException
     */
    public function __construct(
        InstanceConfiguration $instance,
        PlacetoPayIntegrationManager $ppIntegrationManager,
        RouterInterface $router
    )
    {
        parent::__construct($instance);
        $this->ppIntegrationManager = $ppIntegrationManager;
        $this->router = $router;

    }

    /**
     * Sends a payment request.
     * @param Order $order
     * @return string
     * @throws \Dnetix\Redirection\Exceptions\PlacetoPayException
     * @throws LogicException
     */
    public function sendPaymentRequest(Order $order): string
    {
        // build request
        $request = [
            'buyer' => $this->buildBuyer($order->getCustomer()),
            'payment' => $this->buildPayment($order),
            'expiration' => date('c', strtotime('+2 days')),
            'returnUrl' => $this->buildReturnUrl($order->getCode()),
            'ipAddress' => $_SERVER['REMOTE_ADDR'],
            'userAgent' => $_SERVER['HTTP_USER_AGENT']
        ];

        $response = $this->placetoPay->request($request);

        if ($response->isSuccessful()) {

            $this->ppIntegrationManager->createRecord(
                $order, $response->requestId(), $response->processUrl()
            );
            return $response->processUrl();
        } else {
            throw new LogicException($response->message());
        }
    }

    /**
     * Build the buyer structure.
     * @param Customer $customer
     * @return array
     */
    private function buildBuyer(Customer $customer): array
    {
        return [
            "name" => $customer->getName(),
            "surname" => $customer->getSurname(),
            "email" => $customer->getEmail(),
            "mobile" => $customer->getMobile(),
        ];
    }

    /**
     * Build the payment structure.
     * @param Order $order
     * @return array
     */
    private function buildPayment(Order $order): array
    {
        $reference = $order->getCode();
        return [
            'reference' => $reference,
            'description' => 'Testing payment',
            'amount' => [
                'currency' => 'COP',
                'total' => $order->getTotalToPay(),
            ],
        ];

    }

    /**
     * Build the return url.
     * @param string $orderCode
     * @return string
     */
    private function buildReturnUrl(string $orderCode): string
    {
        $argsUrl = ['code' => $orderCode];
        return $this->router->generate('response_pay_order', $argsUrl, UrlGeneratorInterface::ABSOLUTE_URL);
    }
}