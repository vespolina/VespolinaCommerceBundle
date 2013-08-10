<?php

/**
 * (c) 2012 Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\CommerceBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class EventDispatcherListenerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $dispatcher = $container->getDefinition('vespolina_commerce.event_dispatcher');
        foreach ($container->findTaggedServiceIds('vespolina.event_listener') as $id => $events) {
            foreach ($events as $event) {
                $priority = isset($event['priority']) ? $event['priority'] : 0;

                $dispatcher->addMethodCall('addListenerService', array($event['event'], array($id, $event['method']), $priority));
            }
        }
    }
}
