<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\CommerceBundle\Tests\Action\Order;

use Vespolina\Action\Gateway\ActionMemoryGateway;
use Vespolina\Action\Manager\ActionManager;
use Vespolina\CommerceBundle\Action\Order\NotifyCustomer;
use Vespolina\Entity\Action\Action;
use Vespolina\Entity\Action\ActionDefinition;
use Vespolina\Entity\Order\Order;
use Vespolina\Entity\Partner\Partner;


/**
 * Generic action execution for notifying a customer about an update of his order
 *
 * @author Daniel Kucharski <daniel@xerias.be>
 */
class NotifyCustomerTest extends \PHPUnit_Framework_TestCase
{

    protected $actionManager;

    public function setUp()
    {
        //Setup an action manager with in memory definition storage
        $this->actionManager = new ActionManager(new ActionMemoryGateway(), null);
    }

    public function testNotifyCustomer()
    {
        $this->registerActionDefinition('notifyCustomer',
                                        'Vespolina\CommerceBundle\Action\Order\NotifyCustomer',
                                        array('type' => 'new_order', 'template' => 'test.twig'));

        $action = $this->actionManager->createAndExecuteAction('notifyCustomer', $this->getOrder());

        //Test if the action was completed
        $this->assertTrue($action->isCompleted());
    }

    protected function registerActionDefinition($name, $class, $parameters = null)
    {
        $actionDefinition = new ActionDefinition('notifyCustomer', 'Vespolina\CommerceBundle\Action\Order\NotifyCustomer');
        $actionDefinition->setParameters(array('type' => 'new_order', 'template' => 'test.twig'));
        $this->actionManager->addActionDefinition($actionDefinition);
    }

    protected function getOrder()
    {
        $customer = new Partner();
        $customer->setName('James Bond 007');

        $order = new Order();
        $order->setOwner($customer);

        $product = new Product();
        $product->setName('Golden Gun');
        

        return $order;
    }

}
