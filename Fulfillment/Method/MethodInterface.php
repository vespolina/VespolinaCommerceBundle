<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\CommerceBundle\Fulfillment\Method;

/**
 * Interface describe a fulfillment method, eg. "DHL fast shipment"
 * The interface queries such as the generic type of fulfillment
 * such as virtual (mp3 download) or physical (goods delivery)
 *
 * @author Daniel Kucharski <daniel@xerias.be>
 */
interface MethodInterface
{

    const PHYSICAL_FULFILLMENT = 'physical_fulfillment';
    const VIRTUAL_FULFILLMENT = 'virtual_fulfillment';

    public function getName();

    /**
     * Get fulfillment type (eg. physical, virtual, ...)
     *
     * @abstract
     * @return string
     */
    public function getType();

    public function addCategory($category);

    /**
     * Get supported fulfillment categories (eg. light, heavy, ...)
     *
     * @abstract
     * @return mixed
     */
    public function getCategories();
}
