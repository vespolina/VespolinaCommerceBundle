<?php
/**
 * (c) 2012 Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\CommerceBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Vespolina\CommerceBundle\DependencyInjection\Compiler\EventDispatcherListenerPass;
use Vespolina\CommerceBundle\DependencyInjection\Compiler\OrderHandlerFactoryPass;
use Vespolina\CommerceBundle\DependencyInjection\Compiler\ProductHandlerFactoryPass;

class VespolinaCommerceBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new EventDispatcherListenerPass());
        $container->addCompilerPass(new OrderHandlerFactoryPass());
        $container->addCompilerPass(new ProductHandlerFactoryPass());
    }
}
