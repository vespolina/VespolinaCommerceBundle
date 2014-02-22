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

    /**
     * {@inheritdoc}
     */
    public function getOpenOrder($orderId = null, PartnerInterface $owner = null, $orderType = 'default')
    {
        $order = null;
        // check for a valid open order by id
        if ($orderId) {
            $order = $this->orderManager->findOrderById($orderId);
            if ($this->orderManager->isValidOpenOrder($order, $owner)) {
                $this->session->set($this->getOrderSessionName($orderType), $order->getId());

                return $order;
            }
        }

        //Let us check the order manager if an open order can be found in the persistence layer
        if ($owner) {
            $order = $this->orderManager->findOrderByOwner($owner);
            if ($this->orderManager->isValidOpenOrder($order, $owner)) {
                $this->session->set($this->getOrderSessionName($orderType), $order->getId());

                return $order;
            }
        }

        // check the session for an open order
        if ($orderId = $this->session->get($this->getOrderSessionName($orderType))) {
            $order = $this->orderManager->findOrderById($orderId);
            if ($this->orderManager->isValidOpenOrder($order, $owner)) {

                return $order;
            }
        }

        // There is still no order or an order is invalid, so a new order should be created
        $order = $this->orderManager->createOrder();
        $this->orderManager->updateOrder($order);
        if (null != $owner ) {
            $order->setOwner($owner);
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
}
