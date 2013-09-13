<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\CommerceBundle\Action\Order;

use Vespolina\Action\Event\ActionEvent;
use Vespolina\Entity\Order\OrderInterface;
use Vespolina\Partner\Manager\PartnerManagerInterface;
use Vespolina\CommerceBundle\Action\ActionExecution;


class NotifyCustomer extends ActionExecution
{
    protected $partnerManager;
    protected $mailer;
    protected $renderer;

    public function __construct($renderer, $mailer, PartnerManagerInterface $partnerManager)
    {
        $this->renderer = $renderer;
        $this->mailer = $mailer;
        $this->partnerManager = $partnerManager;
    }

    public function onExecute(ActionEvent $event)
    {
        /* @var $order OrderInterface */
        $order = $event->getSubject();

    }
}
