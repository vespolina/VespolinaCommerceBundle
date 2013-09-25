<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\CommerceBundle\Controller\Process;

use Symfony\Component\HttpFoundation\Request;
use Vespolina\CommerceBundle\Form\Type\Process\PaymentFormType;
use Omnipay\Common\CreditCard;
use Omnipay\Common\Exception\InvalidCreditCardException;

class ExecutePaymentController extends AbstractProcessStepController
{
    public function executeAction()
    {
        $processManager = $this->container->get('vespolina.process_manager');
        $request = $this->container->get('request');
        $paymentForm = $this->createPaymentForm();
        $paymentGateway = $this->container->get('vespolina_commerce.payment_gateway.paypal_pro');
        if ($this->isPostForForm($request, $paymentForm)) {
            $paymentForm->bind($request);
            /** @var CreditCard $creditCard */
            $creditCard = $paymentForm->getData();
            // For now use Omnipay\Common\CreditCard's native validate()
            // method but validation should be moved to a yml file using
            // the Symfony2 validation component
            try {
                $creditCard->validate();
                $response = $paymentGateway->purchase(array('amount' => '10.00', 'card' => $creditCard))->send();
                if ($response->isSuccessful()) {
                    $process = $this->processStep->getProcess();
                    //Signal enclosing process step that we are done here
                    $process->completeProcessStep($this->processStep);
                    $processManager->updateProcess($process);
                    $this->container->get('session')->getFlashBag()->add('success', 'The transaction was successful.');

                    return $process->execute();
                } else {
                    $this->container->get('session')->getFlashBag()->add('danger', $response->getMessage());
                }
            } catch(InvalidCreditCardException $e) {
                $this->container->get('session')->getFlashBag()->add('danger', $e->getMessage());
            }
        }

        return $this->render('VespolinaCommerceBundle:Process:Step/executePayment.html.twig',
            array(
                'context' => $this->processStep->getContext(),
                'currentProcessStep' => $this->processStep,
                'paymentForm' => $paymentForm->createView()
            )
        );
    }


    /**
     * @return \Symfony\Component\Form\Form
     */
    protected function createPaymentForm()
    {
        $creditCard = new CreditCard();
        $paymentForm = $this->container->get('form.factory')->create(new PaymentFormType(), $creditCard, array());

        return $paymentForm;
    }
}
