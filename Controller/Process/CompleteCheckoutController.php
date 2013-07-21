<?php

namespace Vespolina\CommerceBundle\Controller\Process;

use Symfony\Component\HttpFoundation\Request;
use Vespolina\CommerceBundle\Controller\Process\AbstractProcessStepController;
use Vespolina\CommerceBundle\Form\Type\Process\SelectPaymentMethodFormType;

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
