<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

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
