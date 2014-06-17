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
            'hasPrice' => new \Twig_Function_Method($this, 'hasPrice'),
            'price' => new \Twig_Function_Method($this, 'getPrice'),
        );
    }


    public function getAssetManager()
    {
        return $this->assetManager;
    }

    public function getAssetData($entity, $type)
    {

    }

    public function hasPrice($entity, $type)
    {
        return $entity->getPrice($type) !== null ? true : false;
    }

    public function getPrice($entity, $type, $currency = '')
    {
        $value = $entity->getPrice($type);
        if (null == $value) {
            return;
        }

        return $this->priceFormat(
            $value,
            $currency);
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

		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        /********************************* money_format not available on windows systems */
		//This is a server using Windows : money_format replacement.
        setlocale(LC_ALL, ''); // Locale will be different on each system.
        $locale = localeconv();
        //$amount = 1000000.97;
        //echo $locale['currency_symbol'],
                         // number_format($amount, 2, $locale['decimal_point'], $locale['thousands_sep']);	
			return $left . number_format($amount, 2, $locale['decimal_point'], $locale['thousands_sep']) . $right;
		} else {
			//This is a server not using Windows
			return $left . my_money_format('%i', $amount) . $right;
		}

    }
}
