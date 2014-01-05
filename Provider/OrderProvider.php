<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\CommerceBundle\Provider;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Vespolina\Entity\Order\OrderInterface;
use Vespolina\Entity\Partner\PartnerInterface;
use Vespolina\Entity\Pricing\Element\TotalDoughValueElement;
use Vespolina\Entity\Pricing\PricingSet;
use Vespolina\Order\Manager\OrderManagerInterface;

/**
 * @author Daniel Kucharski <daniel@xerias.be>
 */
class OrderProvider implements OrderProviderInterface
{
    protected $orderManager;
    protected $session;

    public function __construct(OrderManagerInterface $orderManager, SessionInterface $session)
    {
        $this->orderManager = $orderManager;
        $this->session = $session;
    }

    public function getOpenOrder(PartnerInterface $owner = null, $orderType = 'default')
    {
        $order = null;
        if ($orderId = $this->session->get($this->getOrderSessionName($orderType))) {
            $order = $this->orderManager->findOrderById($orderId);
            if ($this->isValidOrder($order, $owner)) {

                return $order;
            }
        }

        //The order did never exist in the session or appear to be invalid.
        //Let us check the order manager if an open order can be found in the persistence layer
        if ($owner) {
            $order = $this->orderManager->findOrderByOwner($owner);
        }

        //If the order is empty or invalid a new order should be created
        if (!$this->isValidOrder($order, $owner)) {
            $order = $this->orderManager->createOrder();
            $this->orderManager->updateOrder($order);
            if (null != $owner ) {
                $order->setOwner($owner);
            }
        }

        $this->session->set($this->getOrderSessionName($orderType), $order->getId());

        return $order;
    }

    public function resetOrder(OrderInterface $order)
    {

    }

    protected function getOrderSessionName($orderType) {

        return 'order_' . $orderType;
    }

    protected function isValidOrder(OrderInterface $order = null, PartnerInterface $owner = null)
    {
        if (null == $order || $order->getId() == null) {

            return false;
        }

        if (null != $owner && $owner != $order->getOwner()) {

            return false;
        }

        // todo: make sure order is still in a usaable state

        return true;
    }
}
