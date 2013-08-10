<?php

/**
 * (c) 2012 - 2013 Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\CommerceBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class OrderHandlerFactoryPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $factory = $container->getDefinition('vespolina_commerce.order_pricing_provider');

        foreach ($container->findTaggedServiceIds('vespolina_commerce.order_handler') as $id => $attr) {
            $factory->addMethodCall('addOrderHandler', array(new Reference($id)));
        }

        //If a taxation manager exists, add it to the provider provider
        if (true === $container->hasDefinition('v_taxation.taxation_manager')) {

            $taxationManagerDefinition = $container->getDefinition('v_taxation.taxation_manager');
            $factory->addMethodCall('setTaxationManager', array($taxationManagerDefinition));
        }
    }
}