<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\CommerceBundle\Action;

use Symfony\Component\DependencyInjection\ContainerAware;
use Vespolina\Action\Execution\ExecutionInterface;
use Vespolina\Entity\Action\ActionInterface;
use Vespolina\Entity\Action\Action;

/**
 * Base action execution class to integrate the Symfony2 DIC container
 *
 * @author Daniel Kucharski <daniel@xerias.be>
 */
abstract class ActionExecution extends ContainerAware implements ExecutionInterface
{

    protected function complete(ActionInterface $action)
    {
        $action->setState(Action::STATE_COMPLETED);
    }
}
