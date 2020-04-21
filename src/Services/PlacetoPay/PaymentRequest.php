<?php

namespace App\Services\PlacetoPay;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class PaymentRequest
 * @package App\Services\PlacetoPay
 */
class PaymentRequest
{

    private $placetoPay;

    private $router;

    public function __construct(InstanceConfiguration $instance, RouterInterface $router)
    {
        $this->placetoPay = $instance->getInstance();
        $this->router = $router;

    }

    public function testRequest(string $reference)
    {
        //$reference = '332f207d8f775d141b82b7f6d6a99382b07b5b51';
        $argsUrl = ['urlCode' => $reference];
        $returnUrl = $this->router->generate('status_order', $argsUrl, UrlGeneratorInterface::ABSOLUTE_URL);
        $request = [
            'payment' => [
                'reference' => $reference,
                'description' => 'Testing payment',
                'amount' => [
                    'currency' => 'USD',
                    'total' => 120,
                ],
            ],
            'expiration' => date('c', strtotime('+2 days')),
            'returnUrl' => $returnUrl,
            'ipAddress' => $_SERVER['REMOTE_ADDR'], //'127.0.0.1',
            'userAgent' => $_SERVER['HTTP_USER_AGENT']//'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36',
        ];

        //dd($request);


        $response = $this->placetoPay->request($request);
        dd($response);
        if ($response->isSuccessful()) {
            // STORE THE $response->requestId() and $response->processUrl() on your DB associated with the payment order
            // Redirect the client to the processUrl or display it on the JS extension
            //header('Location: ' . $response->processUrl());

            return new RedirectResponse($response->processUrl());
        } else {
            // There was some error so check the message and log it
            dd($response->status()->message());
        }
    }
}