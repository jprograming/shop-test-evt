<?php

namespace App\Services\PlacetoPay;

/**
 * Base class to makes request to the PlacetoPay plataform.
 * @package App\Services\PlacetoPay
 */
abstract class AbstractRequest
{

    /**
     * @var \Dnetix\Redirection\PlacetoPay
     */
    protected $placetoPay;

    /**
     * RequestInformation constructor.
     * @param InstanceConfiguration $instance
     * @throws \Dnetix\Redirection\Exceptions\PlacetoPayException
     */
    public function __construct(InstanceConfiguration $instance)
    {
        $this->placetoPay = $instance->getInstance();
    }
}