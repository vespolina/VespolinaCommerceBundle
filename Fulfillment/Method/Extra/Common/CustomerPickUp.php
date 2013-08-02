<?php
/**
 * (c) 2011-2012 Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vespolina\CommerceBundle\Fulfillment\Method\Extra\UPS;

/**
 * Shipment method for allowing a customer to collect his goods
 *
 * @author Daniel Kucharski <daniel@xerias.be>
 */
class CustomerPickUp extends AbstractShipmentMethod
{

    public function __construct()
    {
        parent::__construct();
        $this->setName('customer_pickup');
        $this->setDescription('Pick up the good at one of our locations');
    }

}
