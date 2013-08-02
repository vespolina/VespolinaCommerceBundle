<?php
/**
 * (c) Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vespolina\CommerceBundle\Fulfillment;

use Vespolina\CommerceBundle\Fulfillment\Fulfillment;
use Vespolina\CommerceBundle\Fulfillment\FulfillmentInterface;
use Vespolina\CommerceBundle\Fulfillment\FulfillmentManagerInterface;

/**
 * @author Richard Shank <develop@zestic.com>
 * @author Luis Cordova <cordoval@gmail.com.com>
 */
abstract class FulfillmentManager implements FulfillmentManagerInterface
{
    private $fulfillmentClass;

    public function __construct($fulfillmentClass)
    {
        $this->fulfillmentClass = $fulfillmentClass;
    }

    /**
     * Create a Fulfillment instance
     *
     * @return Vespolina\CommerceBundle\Fulfillment\FulfillmentInterface
     */
    public function createFulfillment($product)
    {
        return new $this->fulfillmentClass($product);
    }

}
