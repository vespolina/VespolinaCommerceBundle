<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\CommerceBundle\Controller\Cart;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Vespolina\Entity\Order\OrderInterface;
use Vespolina\CommerceBundle\Form\Type\Cart\CartType as CartForm;
use Vespolina\CommerceBundle\Controller\AbstractController;

/**
 * @author Richard D Shank <develop@zestic.com>
 */
class DefaultController extends AbstractController
{
    public function quickInspectionAction()
    {
        $order = $this->getOrder();
        //$totalPrice = $order->getPricingSet()->get('totalGross');
        return $this->render('VespolinaCommerceBundle:Cart:quickInspection.html.twig', array('cart' => $order ));
    }

    public function navBarAction()
    {
        $order = $this->getOrder();

        $totalPrice = $order->getPrice();

        return $this->render('VespolinaCommerceBundle:Default:navBar.html.twig', array('cart' => $order, 'totalPrice' => $totalPrice ));
    }

    public function addToCartAction($productId, $orderId = null)
    {
        $product = $this->findProductById($productId);
        $order = $this->getOrder($orderId);
        $orderId = $order->getId();

        $this->container->get('vespolina.order_manager')->addProductToOrder($order, $product);
        $this->finishOrder($order);

        return new RedirectResponse($this->container->get('router')->generate('v_cart_show', array('cartId' => $orderId)));
    }

    public function removeFromCartAction($productId, $orderId = null)
    {
        $order = $this->getOrder($orderId);
        $product = $this->findProductById($productId);

        $this->container->get('vespolina.order_manager')->removeItemFromCart($order, $product);
        $this->finishOrder($order);

        return new RedirectResponse($this->container->get('router')->generate('v_cart_show', array('cartId' => $orderId)));
    }

    public function updateCartAction($orderId = null)
    {
        $request = $this->container->get('request');
        if ($request->getMethod() == 'POST')
        {
            $order = $this->getOrder();
            $data = $request->get('cart');
            foreach ($data['items'] as $item)
            {
                $product = $this->findProductById($item['product']['id']);
                if ($item['quantity'] < 1)
                {
                    $this->container->get('vespolina.order_manager')->removeItemFromCart ($order, $product);
                } elseif ($orderItem = $this->container->get('vespolina.order_manager')->findProductInOrder($order, $product)) {
                    $this->container->get('vespolina.order_manager')->setItemQuantity($orderItem, $item['quantity']);
                }
            }

            //Finish cart is only called when all required cart updates have been performed.
            //It assures amongst that prices are only recalculated once for the entire cart
            $this->finishOrder($order);
        }

        return new RedirectResponse($this->container->get('router')->generate('v_cart_show' ));
    }

    public function showAction($orderId = null)
    {
        $order = $this->getOrder($orderId);

        $form = $this->container->get('form.factory')->create(new CartForm(), $order);

        $template = $this->container->get('templating')->render(sprintf('VespolinaCommerceBundle:Cart:show.html.%s', $this->getEngine()), array('cart' => $order, 'form' => $form->createView()));

        return new Response($template);
    }

    protected function findProductById($productId)
    {
        return $this->container->get('vespolina.product_manager')->findProductById($productId);
    }

    protected function getOrder($orderId = null)
    {
        return $this->container->get('vespolina.order_provider')->getOpenOrder($orderId);
    }

    protected function finishOrder(OrderInterface $order)
    {
        $this->container->get('vespolina.order_manager')->processOrder($order);
        $this->container->get('vespolina.order_manager')->updateOrder($order);
    }

    protected function getEngine()
    {
        return $this->container->getParameter('vespolina_commerce.template.engine');
    }
}