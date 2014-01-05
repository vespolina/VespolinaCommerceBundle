<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\CommerceBundle\Provider;

use Vespolina\Entity\Order\OrderInterface;
use Vespolina\Entity\Partner\PartnerInterface;

/**
 * @author Daniel Kucharski <daniel@xerias.be>
 */
interface OrderProviderInterface
{
    /**
     * Get the order for the current session if no order owner was passed.
     * If a order owner was passed the system will try to lookup an existing order.
     * When no open order could be found a new order will be created;
     *
     * @param \Vespolina\Entity\Partner\PartnerInterface $owner
     * @param $orderType Type of the order, allows the definition of multiple active orders
     * @return mixed
     */
    function getOpenOrder(PartnerInterface $owner = null, $orderType = 'default');

    /**
     * Reset the order (remove items, remove from persistence gateway),...
     */
    function resetOrder(OrderInterface $order);
}
