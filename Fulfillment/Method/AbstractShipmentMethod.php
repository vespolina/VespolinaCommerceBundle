<?php
/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\CommerceBundle\Fulfillment\Method;

use Vespolina\CommerceBundle\Fulfillment\Method\AbstractMethod;
use Vespolina\CommerceBundle\Fulfillment\Method\MethodInterface;
/**
 * @author Daniel Kucharski <daniel@xerias.be>
 */

abstract class AbstractShipmentMethod extends AbstractMethod
{

    protected $supportedZones;

    public function __construct()
    {
        $this->setType(MethodInterface::PHYSICAL_FULFILLMENT);
    }

    public function addSupportedZone($zone)
    {
        $this->supportedZones[] = $zone;
    }

    public function getSupportedZones()
    {
        return $this->supportedZones;
    }

    public function supportsZone($zone)
    {
        return true; //TODO
    }
}
