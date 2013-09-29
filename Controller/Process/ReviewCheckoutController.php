<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\CommerceBundle\Controller\Process;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Vespolina\CommerceBundle\Form\Type\Process\CheckoutReviewFormType;

class ReviewCheckoutController extends AbstractProcessStepController
{
    public function executeAction()
    {
        $processManager = $this->container->get('vespolina.process_manager');
        $request = $this->container->get('request');
        $checkoutReviewForm = $this->createCheckoutReviewedForm();
        if ($this->isPostForForm($request, $checkoutReviewForm)) {

            $checkoutReviewForm->handleRequest($request);

            if ($checkoutReviewForm->isValid()) {

                $process = $this->processStep->getProcess();

                //Signal enclosing process step that we are done here
                $process->completeProcessStep($this->processStep);
                $processManager->updateProcess($process);

                return $process->execute();
            } else {
            }
        } else {

            return $this->render('VespolinaCommerceBundle:Process:Step/reviewCheckout.html.twig',
                array('cart' => $this->processStep->getContext()->get('cart'),
                      'context' => $this->processStep->getContext(),
                      'currentProcessStep' => $this->processStep,
                      'checkoutReviewForm' => $checkoutReviewForm->createView()));
        }
    }

    protected function createCheckoutReviewedForm()
    {
        $checkoutReviewForm = $this->container->get('form.factory')->create(new CheckoutReviewFormType(), array(), array());

        return $checkoutReviewForm;
    }
}
