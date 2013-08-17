<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\CommerceBundle\Twig\Extension;

use Vespolina\Pricing\Manager\PricingManager;
use Vespolina\Pricing\Manager\PricingManagerInterface;
use Vespolina\StoreBundle\Resolver\StoreResolverInterface;

class CommerceExtension extends \Twig_Extension
{
    protected $assetManager;
    protected $pricingManager;
    protected $storeResolver;

    public function __construct(AssetManager $assetManager,
                                PricingManagerInterface $pricingManager,
                                StoreResolverInterface $storeResolver)
    {
        $this->assetManager = $assetManager;
        $this->pricingManager = $pricingManager;
        $this->storeResolver = $storeResolver;
    }

    /**
     * Return a list of supported Twig functions
     *
     * @return array
     */
    public function getFunctions()
    {
        return array(
            'price' => new \Twig_Function_Method($this, 'getPrice')
        );
    }

    /**
     * Retrieve the price by the name of the pricing element for the given entity
     *
     * @param $entity
     * @param $priceElementName
     * @param string $currency
     * @return string
     */
    public function getPrice($entity, $priceElementName, $currency = '')
    {
        if (null == $entity) return;

        $pricingSet = $entity->getPricing();

        if (null == $pricingSet) return;

        $pricingSet = $this->pricingManager->process($entity->getPricing());
        $pricingValue = $pricingSet[$priceElementName];

        if (null == $pricingValue) return;

        $cur = $currency != '' ? $currency :  $pricingValue->getCurrency();

        return $this->priceFormat(
                $pricingValue->getAmount(),
                $cur);
    }

    /**
     * Retrieve the name of the extension
     *
     * @return string
     */
    public function getName()
    {
        return 'commerce_bundle_extension';
    }

    /**
     * Get the active store
     *
     * @return \Vespolina\StoreBundle\Model\StoreInterface
     */
    public function getStore()
    {
        return $this->storeResolver->getStore();
    }

    /**
     * Format the given amount and optionally currency
     *
     * @param $amount
     * @param null $currency
     * @return string
     */
    protected function priceFormat($amount, $currency = null) {

        $left = '';
        $right = '';

        switch ($currency) {

            case 'EUR':  $right = ' €'; break;
            case 'USD' :  $left = '$ '; break;
            case '%' : $right = ' %'; break;
        }

        return $left . money_format('%i', $amount) . $right;
    }
}
