<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\CommerceBundle\Resolver;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Abstract fulfillment method resolver
 *
 * @author Daniel Kucharski <daniel@xerias.be>
 */
abstract class AbstractFulfillmentMethodResolver implements FulfillmentMethodResolverInterface
{

    protected $configuration;
    protected $fulfillmentMethodsByType;

    public function __construct($configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * Retrieve a collection of fulfillment methods by type
     * eg. give back all fulfillment methods for type 'shipment'
     *
     * @param $type
     * @return ArrayCollection
     */
    protected function getFulfillmentMethodsByType($type)
    {
        if (!$this->fulfillmentMethodsByType) {
            $this->loadFulfillmentMethods();
        }

        return $this->fulfillmentMethodsByType->get($type);
    }

    /**
     * Load fulfillment methods from the configuration
     */
    protected function loadFulfillmentMethods()
    {
        $this->fulfillmentMethodsByType = new ArrayCollection();
        foreach ($this->configuration as $type => $configurationFulfillmentMethods) {
            foreach ($configurationFulfillmentMethods  as $configurationFulfillmentMethod) {

                if (array_key_exists('class', $configurationFulfillmentMethod)) {

                    $class = $configurationFulfillmentMethod['class'];
                    $fulfillmentMethod = new $class();

                    $fulfillmentMethodsInType = $this->fulfillmentMethodsByType->get($type);

                    if (!$fulfillmentMethodsInType) {
                        $fulfillmentMethodsInType = new ArrayCollection();
                        $this->fulfillmentMethodsByType->set($type, $fulfillmentMethodsInType);
                    }
                    $fulfillmentMethodsInType->add($fulfillmentMethod);
               }
            }
        }
    }
}
