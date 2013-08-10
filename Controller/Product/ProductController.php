<?php

/**
* (c) 2011 Vespolina Project http://www.vespolina-project.org
*
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Vespolina\CommerceBundle\Controller\Product;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Vespolina\CommerceBundle\Model\ProductInterface;

/**
 * CommerceBundle
 *
 * @author Joris de Wit <joris.w.dewit@gmail.com>
 * @author Richard D Shank <develop@zestic.com>
 * @author Luis E Cordova <cordoval@gmail.com>
 */
class ProductController extends ContainerAware
{
    /**
     * Show all products
     */
    public function listAction()
    {
        $products = $this->container->get('vespolina.product_manager')->findBy(array());

        return $this->container->get('templating')->renderResponse('VespolinaCommerceBundle:Product:list.html.'.$this->getEngine(), array('products' => $products));
    }

    /**
     * Show one product by object id
     */
    public function showAction($id)
    {
        $product = $this->container->get('vespolina.product_manager')->findProductById($id);

        if (!$product) {
            throw new NotFoundHttpException('The product does not exist!');
        }

        return $this->container->get('templating')->renderResponse('VespolinaCommerceBundle:Product:show.html.'.$this->getEngine(), array('product' => $product));
    }

    /**
     * Edit one product, show the edit form
     */
    public function editAction($id)
    {
        $product = $this->container->get('vespolina.product_manager')->findProductById($id);

        if (!$product) {
            throw new NotFoundHttpException('The product does not exist!');
        }

        $formHandler = $this->container->get('vespolina.product.form.handler');

        $process = $formHandler->process($product);
        if ($process) {
            $this->setFlash('vespolina_product_updated', 'success');
            $url = $this->container->get('router')->generate('vespolina_product_list');

            return new RedirectResponse($url);
        }

        $form = $this->container->get('vespolina.product.form');
        $form->setData($product);

        return $this->container->get('templating')->renderResponse('VespolinaCommerceBundle:Product:edit.html.'.$this->getEngine(), array(
            'form'                   => $form->createView(),
            'id'                     => $id,
            'configuredOptionGroups' => $this->getConfiguredOptionsGroups(),
        ));
    }

    /**
     * Delete one product, then show list
     */
    public function deleteAction($id)
    {
        $product = $this->container->get('vespolina.product_manager')->findProductById($id);

        if (!$product) {
            throw new NotFoundHttpException('The product does not exist!');
        }

        $dm = $this->container->get('doctrine.odm.mongodb.document_manager');
        $dm->remove($product);
        $dm->flush();

        $this->setFlash('vespolina_product_deleted', 'success');
        $url = $this->container->get('router')->generate('vespolina_product_list');
        return new RedirectResponse($url);
    }

    /**
     * Show the new form
     */
    public function newAction()
    {
        $form = $this->container->get('vespolina.product.form');

        return $this->container->get('templating')->renderResponse('VespolinaCommerceBundle:Product:new.html.'.$this->getEngine(), array(
            'form'                   => $form->createView(),
            'configuredOptionGroups' => $this->getConfiguredOptionsGroups(),
            'product'  => $this->container->get('vespolina.product_manager')->createProduct(),
       ));
    }

    /**
     * Create a product
     */
    public function createAction()
    {
        $form = $this->container->get('vespolina.product.form');
        $formHandler = $this->container->get('vespolina.product.form.handler');

        $process = $formHandler->process();
        if ($process) {
            $user = $form->getData();

            $this->setFlash('vespolina_product_created', 'success');
            $url = $this->container->get('router')->generate('vespolina_product_list');

            return new RedirectResponse($url);
        }

        return $this->container->get('templating')->renderResponse('VespolinaCommerceBundle:Product:new.html.'.$this->getEngine(), array(
            'form' => $form->createView(),
        ));
    }

    protected function getConfiguredOptionsGroups()
    {
        $groupData = array();
        foreach ($this->container->get('vespolina.product.admin_manager')->findOptionGroupsData() as $optionGroup) {
            $id = (string)$optionGroup['_id'];
            unset($optionGroup['_id']);
            $groupData[$id] = $optionGroup;
        }
        return $groupData;
    }

    protected function setFlash($action, $value)
    {
        $this->container->get('session')->setFlash($action, $value);
    }

    protected function getEngine()
    {
        return 'twig'; // HACK ALERT!
// todo:        return $this->container->getParameter('v_product.template.engine');
    }

    protected function getProductFormOptions()
    {
        $pm = $this->container->get('vespolina.product_manager');
        $options['attributes']['code']['label'] = $pm->getPrimaryIdentifierLabel();
        return $options;
    }
}
