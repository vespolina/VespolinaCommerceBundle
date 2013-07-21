<?php

namespace Vespolina\CommerceBundle\Controller\Process;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Vespolina\CommerceBundle\Form\Type\Process\PaymentFormType;
use Vespolina\CommerceBundle\Controller\Process\AbstractProcessStepController;

class ExecutePaymentController extends AbstractProcessStepController
{
    public function executeAction()
    {
        $processManager = $this->container->get('vespolina.process_manager');
        $request = $this->container->get('request');
        $paymentForm = $this->createPaymentForm();

        if ($this->isPostForForm($request, $paymentForm)) {

            $paymentForm->bindRequest($request);

            if ($paymentForm->isValid()) {

                $process = $this->processStep->getProcess();

                //Signal enclosing process step that we are done here
                $process->completeProcessStep($this->processStep);
                $processManager->updateProcess($process);

                return $process->execute();
            } else {
            }
        } else {

            return $this->render('VespolinaCommerceBundle:Process:Step/executePayment.html.twig',
                array(
                    'context' => $this->processStep->getContext(),
                    'currentProcessStep' => $this->processStep,
                    'paymentForm' => $paymentForm->createView()));
        }
    }

    protected function createPaymentForm()
    {
        $paymentForm = $this->container->get('form.factory')->create(new PaymentFormType(), null, array());

        return $paymentForm;
    }
}
