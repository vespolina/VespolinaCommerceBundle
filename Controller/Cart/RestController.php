<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\CommerceBundle\Controller\Cart;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\ViewHandlerInterface;
use FOS\RestBundle\View\View;

use Symfony\Component\DependencyInjection\ContainerAware;
use Vespolina\Entity\Order\OrderInterface;
use Vespolina\Order\Manager\OrderManagerInterface;

/**
 * Controller to access a cart by a REST api
 *
 * @author Daniel Kucharski <daniel@xerias.be>
 */
class RestController extends FOSRestController
{
    protected $orderManager;
    protected $securityContext;
    protected $session;
    protected $viewHandler;

    public function __construct(OrderManagerInterface $orderManager, $securityContext,$session, ViewHandlerInterface $viewHandler)
    {
      $this->orderManager = $orderManager;
      $this->session = $session;
      $this->securityContext = $securityContext;
      $this->viewHandler = $viewHandler;
    }

    public function getCartAction()
    {
        $cart = $this->getCart();

        return $this->createResponse(200, $cart);
    }

    protected function getCart($cartId = null)
    {
        if (null !== $cartId) {

            return $this->orderManager->findCartById($cartId);
        }

        if ($cart = $this->session->get('cart')) {

            return $cart;
        }

        $cart = $this->orderManager->createCart();
        $this->session->set('cart', $cart);

        return $cart;
    }

	 protected function createResponse($statusCode, $data = null)
    {
        $view = View::create()
            ->setStatusCode($statusCode)
            ->setData($data)
        ;

        return $this->viewHandler->handle($view);
    }
}
