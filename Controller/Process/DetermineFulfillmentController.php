<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\CommerceBundle\Controller\Process;

use Symfony\Component\HttpFoundation\Request;
use Vespolina\CommerceBundle\Form\Type\Process\SelectFulfillmentMethodFormType;

class DetermineFulfillmentController extends AbstractProcessStepController
{
    public function executeAction()
    {
        $processManager = $this->getProcessManager();
        $request = $this->container->get('request');
        $selectFulfillmentForm = $this->createSelectFulfillmentForm();

        if ($this->isPostForForm($request, $selectFulfillmentForm)) {

            $selectFulfillmentForm->handleRequest($request);

            if ($selectFulfillmentForm->isValid()) {

                $process = $this->processStep->getProcess();
                $this->processStep->getContext()->set('fulfillment_method', $selectFulfillmentForm->getData());

                //Signal enclosing process step that we are done here
                $process->completeProcessStep($this->processStep);
                $processManager->updateProcess($process);

                return $process->execute();

            } else {
            }
        } else {

            return $this->render('VespolinaCommerceBundle:Process:Step/determineFulfillment.html.twig',
                array('currentProcessStep' => $this->processStep,
                      'selectFulfillmentForm' => $selectFulfillmentForm->createView()));

        }
    }

    protected function createSelectFulfillmentForm()
    {
        $fulfillment = $this->processStep->getContext()->get('fulfillment_method');

        $selectFulfillmentForm = $this->container->get('form.factory')->create(new SelectFulfillmentMethodFormType($this->getFulfillmentChoices()), $fulfillment, array());

        return $selectFulfillmentForm;
    }

    protected function getFulfillmentChoices()
    {
        // Use the fulfillment method resolver to get back a list of supported fulfillment methods
        $fulfillmentMethodResolver = $this->container->get('vespolina_commerce.fulfillment_method_resolver');
        $cart = $this->processStep->getContext()->get('cart');

        // Collect all products from the cart
        $products = array();
        $fulfillmentChoices = array();

        foreach ($cart->getItems() as $cartItem) {
            $products[] = $cartItem->getProduct();
        }
        $fulfillmentMethods = $fulfillmentMethodResolver->resolveFulfillmentMethods($products, null);

        foreach($fulfillmentMethods as $fulfillmentMethod) {

            $fulfillmentChoices[$fulfillmentMethod->getName()] = $fulfillmentMethod->getDescription();
        }

        return $fulfillmentChoices;
    }

    protected function loadProcess($processId) {

        if (!$this->processStep) {
            $this->processStep = $this->getCurrentProcessStepByProcessId($processId);
        }
    }
}
