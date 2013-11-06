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
    /**
     * @var \Vespolina\CommerceBundle\Process\AbstractProcessStep
     */
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

    /**
     * @param $processId
     * @return ProcessStepInterface
     * @throws \InvalidArgumentException
     */
    protected function getCurrentProcessStepByProcessId($processId)
    {
        if (!$process = $this->getProcessManager()->findProcessById($processId)) {
            throw new \InvalidArgumentException("Now process was found for processId {$processId}");
        }

        return $process->getCurrentProcessStep();
    }

    /**
     * @return \Vespolina\CommerceBundle\Process\ProcessManager
     */
    public function getProcessManager()
    {
        return $this->container->get('vespolina.process_manager');
    }
}
