<?php

/*
 * This file is part of the LGS/DataImporterBundle package.
 *
 * (c) 2014 Lighthouse Guidance Systems, Inc., <info@lhgsystems.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace Vespolina\CommerceBundle\Tests\Twig\Extension;

use Vespolina\CommerceBundle\Twig\Extension\CommerceExtension;
use Vespolina\Entity\Product\Product;

class CommerceExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testPriceFormat()
    {
        $extension = new CommerceExtension();

        $product = $this->getMock('Vespolina\Entity\Product\Product', 'getPrice');
        $product
            ->expects($this->once())
            ->method('getPrice')
            ->will($this->returnValue(3.4));
        $this->assertSame('3.4 €', $extension->getPrice($product, 'unit', 'EUR'), 'a scalar should return a single value');
        $product
            ->expects($this->once())
            ->method('getPrice')
            ->will($this->returnValue([3.4, 5.7]));
        $this->assertSame('3.4 € - 5.7 €', $extension->getPrice($product, 'unit', 'EUR'), 'two elements in the array should return a dash between the values');
        $product
            ->expects($this->once())
            ->method('getPrice')
            ->will($this->returnValue([3.4, 5.7, 6.4]));
        $this->assertSame('3.4 €, 5.7 €, 6.4 €', $extension->getPrice($product, 'unit', 'EUR'), 'more than two should put commas between the values');
    }
}
