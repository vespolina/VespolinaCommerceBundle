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
use Vespolina\Entity\Order\CartInterface;
use Vespolina\CommerceBundle\Form\Type\Cart\CartType as CartForm;
use Vespolina\CommerceBundle\Controller\AbstractController;

/**
 * @author Richard D Shank <develop@zestic.com>
 */
class DefaultController extends AbstractController
{
    public function quickInspectionAction()
    {
        $cart = $this->getCart();
        //$totalPrice = $cart->getPricingSet()->get('totalGross');
        return $this->render('VespolinaCommerceBundle:Cart:quickInspection.html.twig', array('cart' => $cart ));
    }

    public function navBarAction()
    {
        $cart = $this->getCart();

        $totalPrice = $cart->getPricingSet()->get('totalGross');

        return $this->render('VespolinaCommerceBundle:Default:navBar.html.twig', array('cart' => $cart, 'totalPrice' => $totalPrice ));
    }

    public function addToCartAction($productId, $cartId = null)
    {
        $product = $this->findProductById($productId);
        $cart = $this->getCart($cartId);

        $this->container->get('vespolina.order_manager')->addProductToOrder($cart, $product);
        $this->finishCart($cart);

        return new RedirectResponse($this->container->get('router')->generate('v_cart_show', array('cartId' => $cartId)));
    }

    public function removeFromCartAction($productId, $cartId = null)
    {
        $cart = $this->getCart($cartId);
        $product = $this->findProductById($productId);

        $this->container->get('vespolina.order_manager')->removeItemFromCart($cart, $product);
        $this->finishCart($cart);

        return new RedirectResponse($this->container->get('router')->generate('v_cart_show', array('cartId' => $cartId)));
    }

    public function updateCartAction ($cartId = null)
    {
        $request = $this->container->get('request');
        if ($request->getMethod() == 'POST')
        {
            $cart = $this->getCart();
            $data = $request->get('cart');
            foreach ($data['items'] as $item)
            {
                $product = $this->findProductById($item['product']['id']);
                if ($item['quantity'] < 1)
                {
                    $this->container->get('vespolina.order_manager')->removeItemFromCart ($cart, $product);
                } elseif ($cartItem = $this->container->get('vespolina.order_manager')->findProductInOrder($cart, $product)) {
                    $this->container->get('vespolina.order_manager')->setItemQuantity($cartItem, $item['quantity']);
                }
            }

            //Finish cart is only called when all required cart updates have been performed.
            //It assures amongst that prices are only recalculated once for the entire cart
            $this->finishCart($cart);
        }

        return new RedirectResponse($this->container->get('router')->generate('v_cart_show' ));
    }

    public function showAction($cartId = null)
    {
        $cart = $this->getCart($cartId);

        $form = $this->container->get('form.factory')->create(new CartForm(), $cart);

        $template = $this->container->get('templating')->render(sprintf('VespolinaCommerceBundle:Cart:show.html.%s', $this->getEngine()), array('cart' => $cart, 'form' => $form->createView()));

        return new Response($template);
    }

    protected function findProductById($productId)
    {
        return $this->container->get('vespolina.product_manager')->findProductById($productId);
    }

    protected function getCart()
    {
        return $this->container->get('vespolina.cart_provider')->getOpenCart();
    }

    protected function finishCart(CartInterface $cart)
    {
        $this->container->get('vespolina.order_manager')->processOrder($cart);
        $this->container->get('vespolina.order_manager')->updateOrder($cart);
    }

    protected function getEngine()
    {
        return $this->container->getParameter('vespolina_commerce.template.engine');
    }
}