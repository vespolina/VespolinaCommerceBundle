<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\CommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerAware;

class AbstractController extends ContainerAware
{
    public function render($view, array $parameters = array(), Response $response = null)
    {
       return ($this->container->get('templating')->renderResponse($view, $parameters, $response));
    }

    protected function getEngine()
    {
        return 'twig';
    }
}
