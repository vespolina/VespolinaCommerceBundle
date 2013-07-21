<?php
/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vespolina\CommerceBundle\Controller\Order;

use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;

use Symfony\Component\DependencyInjection\ContainerAware;
use Vespolina\Order\Manager\OrderManagerInterface;

/**
 * @author Daniel Kucharski <daniel@xerias.be>
 */
class RestController extends FOSRestController
{
    protected $orderManager;
    protected $viewHandler;


    public function __construct(OrderManagerInterface $orderManager, ViewHandlerInterface $viewHandler)
    {
      $this->orderManager = $orderManager;
      $this->viewHandler = $viewHandler;

    }

    public function getOrdersAction()
    {

        $orders = $this->orderManager->findBy(array());

        return $this->createResponse(200, $orders);
    }

    public function getOrderAction($orderId)
    {
        if (null == $orderId) {

            return $this->createResponse(404);
        }

        $order = $this->orderManager->findOrderById($orderId);

        if (null != $order) {

            return $this->createResponse(200, $order);
        }

        return $this->createResponse(404);
    }

    protected function createResponse($statusCode, $data = null)
    {
        $view = View::create()
            ->setStatusCode($statusCode)
            ->setData($data);

        return $this->viewHandler->handle($view);
    }
}
