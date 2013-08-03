<?php
/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vespolina\CommerceBundle\Resolver;

/**
 * Interface to resolve fulfillment for a collection of products
 *
 * @author Daniel Kucharski <daniel@xerias.be>
 */
interface FulfillmentMethodResolverInterface
{

    public function resolveFulfillmentMethods($products, $zone = null);
}
