<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\CommerceBundle\Provider;

use Vespolina\Entity\Order\CartInterface;
use Vespolina\Entity\Partner\PartnerInterface;

/**
 * @author Daniel Kucharski <daniel@xerias.be>
 */
interface CartProviderInterface
{
    /**
     * Get the cart for the current session if no cart owner was passed.
     * If a cart owner was passed the system will try to lookup an existing cart.
     * When no open cart could be found a new cart will be created;
     *
     * @param \Vespolina\Entity\Partner\PartnerInterface $owner
     * @param $cartType Type of the cart, allows the definition of multiple active carts
     * @return mixed
     */
    function getOpenCart(PartnerInterface $owner = null, $cartType = 'default');

    /**
     * Reset the cart (remove items, remove from persistence gateway),...
     */
    function resetCart(CartInterface $cart);
}
