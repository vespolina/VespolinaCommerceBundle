<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\CommerceBundle\Controller\Process;

use Symfony\Component\HttpFoundation\Request;

class CompleteCheckoutController extends AbstractProcessStepController
{
    public function executeAction()
    {
        $process = $this->getProcessStep()->getProcess();
        $processManager = $this->container->get('vespolina.process_manager');
        $request = $this->container->get('request');

        $cart = $process->getContext()->get('cart');

        //Reset session cart
        $cart->clearItems();

        //Todo: Kill this process in the user session

        return $this->render('VespolinaCommerceBundle:Process:Step/completeCheckout.html.twig',
            array('currentProcessStep' => $this->processStep));
    }
}
