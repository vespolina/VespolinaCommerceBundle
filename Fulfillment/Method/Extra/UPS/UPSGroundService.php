<?php
/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vespolina\CommerceBundle\Fulfillment\Method\Extra\UPS;

use Vespolina\CommerceBundle\Fulfillment\Method\Extra\UPS\AbstractUPSShipmentMethod;
/**
 * @author Daniel Kucharski <daniel@xerias.be>
 */
class UPSGroundService extends AbstractUPSShipmentMethod
{

    public function __construct()
    {
        parent::__construct();
        $this->setName('ups_ground_service');
        $this->setDescription('UPS Ground Service');
    }

}
