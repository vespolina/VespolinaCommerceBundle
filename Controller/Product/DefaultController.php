<?php

namespace Vespolina\CommerceBundle\Controller\Product;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function detailAction($slug)
    {
        $productManager = $this->container->get('vespolina.product_manager');

        $product = $productManager->findProductBySlug($slug);

        return $this->render('VespolinaCommerceBundle:Default:detail.html.twig', array('product' => $product));
    }

}
