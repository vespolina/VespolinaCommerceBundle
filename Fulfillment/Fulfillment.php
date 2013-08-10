<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\CommerceBundle\Fulfillment;

use Vespolina\CommerceBundle\Fulfillment\Manager\FulfillmentInterface;

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
