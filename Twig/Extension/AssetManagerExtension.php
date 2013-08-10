<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\CommerceBundle\Twig\Extension;

class AssetManagerExtension extends \Twig_Extension
{
    private $assetManager;

    public function __construct(AssetManager $assetManager = null)
    {
        $this->assetManager = $assetManager;
    }

    public function getFunctions()
    {
        return array(
            'assetManager' => new \Twig_Function_Method($this, 'getAssetManager')
        );
    }

    public function getAssetManager()
    {
        return $this->assetManager;
    }

    public function getName()
    {
        return 'commerce_bundle_asset_manager';
    }
}
