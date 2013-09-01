<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\CommerceBundle\Action\Order;

use Symfony\Bundle\TwigBundle\TwigEngine;
use Vespolina\CommerceBundle\Action\ActionExecution;
use Vespolina\Entity\Action\ActionInterface;


/**
 * Notify the customer of an update of his order
 *
 * @author Daniel Kucharski <daniel@xerias.be>
 */
class NotifyCustomer extends ActionExecution
{
    protected $templating;

    public function __construct(TwigEngine $templating) {

            $this->templating = $templating;
    }

    public function execute(ActionInterface $action)
    {
        $this->container->get('twig');

        $this->complete($action);
    }
}
