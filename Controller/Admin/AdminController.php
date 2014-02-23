<?php

namespace Vespolina\CommerceBundle\Controller\Admin;

use Symfony\Component\DependencyInjection\ContainerAware;

class AdminController extends ContainerAware
{
    public function dashboardAction()
    {
        return $this->container->get('templating')->renderResponse('VespolinaCommerceBundle:Admin:dashboard.html.twig');
    }
}