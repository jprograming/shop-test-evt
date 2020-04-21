<?php

namespace App\Services\PlacetoPay;

use Dnetix\Redirection\PlacetoPay;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Class that handles the PlacetoPay instance.
 * @package App\Services\PlacetoPay
 */
class InstanceConfiguration
{

    /**
     * @var PlacetoPay
     */
    private $instance;

    /**
     * @var ParameterBagInterface
     */
    private $params;

    /**
     * Constructor.
     * @param ParameterBagInterface $params
     */
    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    /**
     * @return PlacetoPay
     * @throws \Dnetix\Redirection\Exceptions\PlacetoPayException
     */
    public function getInstance(): PlacetoPay
    {
        if (!$this->instance) {
            $this->createInstance();
        }

        return $this->instance;
    }

    /**
     * Creates a new instance of PlacetoPay
     * @throws \Dnetix\Redirection\Exceptions\PlacetoPayException
     */
    private function createInstance()
    {
        $parametes = [
            'login' => $this->params->get('placeto_pay_login'),
            'tranKey' => $this->params->get('placeto_pay_trankey'),
            'url' => $this->params->get('placeto_pay_base_url'),
            'rest' => [
                'timeout' => 45,
                'connect_timeout' => 30,
            ]
        ];
        //dd($parametes);
        $this->instance = new PlacetoPay($parametes);
    }
}