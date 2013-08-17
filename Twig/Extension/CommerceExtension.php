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

class CommerceExtension extends \Twig_Extension
{
    protected $assetManager;
    protected $pricingManager;

    public function __construct(AssetManager $assetManager = null, PricingManagerInterface $pricingManager = null)
    {
        $this->assetManager = $assetManager;
        $this->pricingManager = $pricingManager;
    }

    public function getFunctions()
    {
        return array(
            'assetManager' => new \Twig_Function_Method($this, 'getAssetManager'),
            'price' => new \Twig_Function_Method($this, 'getPrice')
        );
    }

    public function getAssetManager()
    {
        return $this->assetManager;
    }

    public function getPrice($entity, $priceElementName, $currency = '')
    {
        if (null == $entity->getPricing()) return;
        $pricingSet = $this->pricingManager->process($entity->getPricing());
        $pricingValue = $pricingSet[$priceElementName];

        if (null == $pricingValue) return;
        
        $cur = $currency != '' ? $currency :  $pricingValue->getCurrency();

        return $this->priceFormat(
                $pricingValue->getAmount(),
                $cur);
    }

    public function getName()
    {
        return 'commerce_bundle_extension';
    }

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
