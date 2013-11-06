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
use Payum\Registry\RegistryInterface;
use Payum\Bundle\PayumBundle\Security\TokenFactory;

class ExecutePaymentController extends AbstractProcessStepController
{
    public function executeAction()
    {
        $paymentName = 'paypal_pro_checkout_via_omnipay';
        $processManager = $this->getProcessManager();
        $request = $this->container->get('request');

        $paymentForm = $this->createPaymentForm();
        $process = $this->processStep->getProcess(); 
        /** @var \Vespolina\CommerceBundle\ProcessScenario\Checkout\CheckoutProcessB2C $process */
        $process->completeProcessStep($this->processStep);
        $processManager->updateProcess($process);
 //       var_dump($process->execute()); die;
//        $paymentGateway = $this->container->get('vespolina_commerce.payment_gateway.paypal_pro');
        if ($this->isPostForForm($request, $paymentForm)) {
            $paymentForm->handleRequest($request);
            /** @var CreditCard $creditCard */
            $creditCard = $paymentForm->getData();
            // For now use Omnipay\Common\CreditCard's native validate()
            // method but validation should be moved to a yml file using
            // the Symfony2 validation component
            try {
                $creditCard->validate();
                $storage = $this->getPayum()->getStorageForClass(
                    'Vespolina\DefaultStoreBundle\Document\OmnipayPaymentDetails',
                    $paymentName
                );
                $paymentDetails = $storage->createModel();
                $paymentDetails['amount'] = (float) 10;
                $paymentDetails['card'] = $creditCard;
                $storage->updateModel($paymentDetails);

                $process = $this->processStep->getProcess();
                $process->completeProcessStep($this->processStep);
                $processManager->updateProcess($process);

                $captureToken = $this->getTokenFactory()->createCaptureToken(
                    $paymentName,
                    $paymentDetails,
//                    'acme_payment_details_view'
                    $process->execute()
                );

                $paymentDetails['returnUrl'] = $captureToken->getTargetUrl();
                $paymentDetails['cancelUrl'] = $captureToken->getTargetUrl();

                $storage->updateModel($paymentDetails);

                return $this->container->get('router')->redirect($captureToken->getTargetUrl());
//                $response = $paymentGateway->purchase(array('amount' => '10.00', 'card' => $creditCard))->send();
//                if ($response->isSuccessful()) {
//                    $process = $this->processStep->getProcess();
//                    //Signal enclosing process step that we are done here
//                    $process->completeProcessStep($this->processStep);
//                    $processManager->updateProcess($process);
//                    $this->container->get('session')->getFlashBag()->add('success', 'The transaction was successful.');
//
//                    return $process->execute();
//                } else {
//                    $this->container->get('session')->getFlashBag()->add('danger', $response->getMessage());
//                }
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

    /**
     * @return RegistryInterface
     */
    protected function getPayum()
    {
        return $this->container->get('payum');
    }

    /**
     * @return TokenFactory
     */
    protected function getTokenFactory()
    {
        return $this->container->get('payum.security.token_factory');
    }
}
