<?php

namespace Vespolina\CommerceBundle\Fulfillment;

use Vespolina\CommerceBundle\Fulfillment\FulfillmentInterface;

abstract class Fulfillment implements FulfillmentInterface
{
    private $state;
    private $product;

    public function __construct($product)
    {
        $this->product = $product;
    }

    public function setState($state)
    {
        $this->state = $state;
    }

    public function getState()
    {
        return $this->state;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function setProduct($product)
    {
        $this->product = $product;
    }
}
