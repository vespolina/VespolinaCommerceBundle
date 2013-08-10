<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\CommerceBundle\Controller\Process;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Vespolina\CommerceBundle\Controller\AbstractController;
use Vespolina\CommerceBundle\Process\ProcessStepInterface;

class ProcessController extends AbstractController
{
    public function processNavigatorAction(ProcessStepInterface $currentProcessStep)
    {
        $process = $currentProcessStep->getProcess();

        return $this->render('VespolinaCommerceBundle:Process:processNavigator.html.twig',
            array('currentProcessStep' => $currentProcessStep,
                  'processSteps' => $process->getProcessSteps(),
                  'process'      => $process));
    }
}
