<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\CommerceBundle\Tests\Action\Order;

use Symfony\Bundle\FrameworkBundle\Templating\TemplateFilenameParser;
use Symfony\Bundle\SecurityBundle\Tests\Functional\WebTestCase;
use Symfony\Bundle\TwigBundle\Loader\FilesystemLoader;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\HttpKernel\Config\FileLocator;
use Vespolina\Action\Gateway\ActionMemoryGateway;
use Vespolina\Action\Manager\ActionManager;
use Vespolina\CommerceBundle\Action\Order\NotifyCustomer;
use Vespolina\CommerceBundle\Tests\AppKernel;
use Vespolina\Entity\Action\Action;
use Vespolina\Entity\Action\ActionDefinition;
use Vespolina\Entity\Order\Order;
use Vespolina\Entity\Partner\Partner;


/**
 * Generic action execution for notifying a customer about an update of his order
 *
 * @author Daniel Kucharski <daniel@xerias.be>
 */
class NotifyCustomerTest extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{
    protected $actionManager;

    public function setUp()
    {
        //Setup an action manager with in memory definition storage
        $this->actionManager = new ActionManager(new ActionMemoryGateway(), null);

        $this->client = self::createClient();

        parent::setUp();
    }

    public function testNotifyCustomer()
    {

        $renderer = new TwigEngine(new \Twig_Environment(), new TemplateFilenameParser(), new FilesystemLoader());
        $notifyCustomer = new NotifyCustomer($renderer);
        $this->registerActionDefinition('notifyCustomer',
                                        $notifyCustomer,
                                        array('type' => 'new_order', 'template' => 'test.twig'));

        $action = $this->actionManager->createAndExecuteAction('notifyCustomer', $this->getOrder());

        //Test if the action was completed
        $this->assertTrue($action->isCompleted());
    }

    protected function registerActionDefinition($name, $executionClass, $parameters = null)
    {
        $actionDefinition = new ActionDefinition('notifyCustomer', 'Vespolina\CommerceBundle\Action\Order\NotifyCustomer');
        $actionDefinition->setParameters(array('type' => 'new_order', 'template' => 'test.twig'));
        $this->actionManager->addActionDefinition($actionDefinition);
        $this->actionManager->addExecutionClass($executionClass);
    }

    protected function getOrder()
    {
        $customer = new Partner();
        $customer->setName('James Bond 007');

        $order = new Order();
        $order->setOwner($customer);

        return $order;
    }

}
