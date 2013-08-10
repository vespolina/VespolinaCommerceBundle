<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\CommerceBundle\Controller\Process;

use Vespolina\CommerceBundle\Controller\AbstractController;
use Vespolina\CommerceBundle\Process\ProcessStepInterface;

class AbstractProcessStepController extends AbstractController
{
    protected $processStep;

    public function completeProcessStep()
    {
        $process = $this->processStep->getProcess();
        $process->completeProcessStep($this->processStep);

        return $process->execute();
    }

    public function isPostForForm($request, $form) {

        return $request->request->has($form->getName());
    }

    public function setProcessStep(ProcessStepInterface $processStep)
    {
        $this->processStep = $processStep;
    }

    /**
     * @return \Vespolina\CommerceBundle\Process\AbstractProcessStep
     */
    public function getProcessStep()
    {
        return $this->processStep;
    }

    protected function getCurrentProcessStepByProcessId($processId)
    {
        $processManager = $this->container->get('vespolina.process_manager');
        $process = $processManager->findProcessById($processId);
        if ($process) {

            return $process->getCurrentProcessStep();
        }
    }
}
