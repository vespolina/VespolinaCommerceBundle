<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\CommerceBundle\Provider;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Vespolina\Entity\Order\CartInterface;
use Vespolina\Entity\Partner\PartnerInterface;
use Vespolina\Entity\Pricing\Element\TotalDoughValueElement;
use Vespolina\Entity\Pricing\PricingSet;
use Vespolina\Order\Manager\OrderManagerInterface;

/**
 * @author Daniel Kucharski <daniel@xerias.be>
 */
class CartProvider implements CartProviderInterface
{
    protected $orderManager;
    protected $session;

    public function __construct(OrderManagerInterface $orderManager, SessionInterface $session)
    {
        $this->orderManager = $orderManager;
        $this->session = $session;
    }

    public function getOpenCart(PartnerInterface $owner = null, $cartType = 'default')
    {
        $cart = $this->session->get($this->getCartSessionName($cartType));

        if ($this->isValidCart($cart, $owner)) {

            return $cart;
        }

        //The cart did never exist in the session or appear to be invalid.
        //Let us check the order manager if an open cart can be found in the persistence layer

        if ($owner) {
            $cart = $this->orderManager->findCartByOwner($owner);
        }

        //If the cart is empty or invalid a new cart should be created
        if (!$this->isValidCart($cart, $owner)) {
            $cart = $this->orderManager->createCart();
            $this->orderManager->updateOrder($cart);
            if (null != $owner ) {
                $cart->setOwner($owner);
            }
            $cart->setPricing(new PricingSet(new TotalDoughValueElement()));
        }

        $this->session->set($this->getCartSessionName($cartType), $cart);

        return $cart;
    }

    public function resetCart(CartInterface $cart)
    {

    }

    protected function getCartSessionName($cartType) {

        return 'cart_' . $cartType;
    }

    protected function isValidCart(CartInterface $cart = null, PartnerInterface $owner = null)
    {
        if (null == $cart || $cart->getId() == null) {

            return false;
        }

        if (null != $owner && $owner != $cart->getOwner()) {

            return false;
        }

        return true;
    }
}
