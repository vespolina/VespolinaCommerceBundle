<?php

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
