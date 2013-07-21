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
 * @author Richard D Shank <develop@zestic.com>
 */

class OptionGroupController extends ContainerAware
{
    public function listAction()
    {
        $optionGroups = $this->container->get('vespolina.product.admin_manager')->findOptionGroupsBy(array());

        return $this->renderResponse('VespolinaCommerceBundle:OptionGroup:list.html', array(
            'optionGroups' => $optionGroups,
        ));
    }

    public function showAction($id)
    {
        $optionGroup = $this->container->get('vespolina.product.admin_manager')->findOptionGroupById($id);

        if (!$optionGroup) {
            throw new NotFoundHttpException('The option group does not exist!');
        }

        return $this->renderResponse('VespolinaCommerceBundle:OptionGroup:show.html', array(
            'optionGroup' => $optionGroup,
        ));
    }

    public function editAction($id)
    {
        $optionGroup = $this->container->get('vespolina.product.admin_manager')->findOptionGroupById($id);

        if (!$optionGroup) {
            throw new NotFoundHttpException('The option group does not exist!');
        }

        $formHandler = $this->container->get('vespolina.option_group.form.handler');

        $process = $formHandler->process($optionGroup);
        if ($process) {
            $this->setFlash('vespolina_option_group_updated', 'success');
            $url = $this->container->get('router')->generate('vespolina_option_group_list');

            return new RedirectResponse($url);
        }

        $form = $this->container->get('vespolina.configured_option_group.form');
        $form->setData($optionGroup);

        return $this->renderResponse('VespolinaCommerceBundle:OptionGroup:edit.html', array(
            'form'        => $form->createView(),
            'optionGroup' => $optionGroup,
        ));
    }

    public function cloneAction($id)
    {
        $adminMgr = $this->container->get('vespolina.product.admin_manager');
        $original = $adminMgr->findOptionGroupById($id);

        if (!$original) {
            throw new NotFoundHttpException('The option group does not exist!');
        }

        $optionGroup = clone $original;
        $ro = new \ReflectionObject($optionGroup);
        $id = $ro->getProperty('id');
        $id->setAccessible(true);
        $id->setValue($optionGroup, null);

        $optionGroup->setName($original->getName() . ' (copy)');
        $adminMgr->update($optionGroup);

        $url = $this->container->get('router')->generate('vespolina_option_group_edit', array('id' => $optionGroup->getId()));

        return new RedirectResponse($url);
    }

    public function deleteAction($id)
    {
        $this->container->get('vespolina.product.admin_manager')->deleteOptionGroupById($id);

        $this->setFlash('vespolina_option_group_deleted', 'success');
        $url = $this->container->get('router')->generate('vespolina_option_group_list');

        return new RedirectResponse($url);
    }

    public function newAction()
    {
        $form = $this->container->get('vespolina.configured_option_group.form');
        $formHandler = $this->container->get('vespolina.option_group.form.handler');

        $optionGroup = $this->container->get('vespolina.product.admin_manager')->createOptionGroup();
        $form->setData($optionGroup);

        if ($this->container->get('request')->getMethod() === 'POST') {
            $process = $formHandler->process($optionGroup);
            if ($process) {
                $this->setFlash('vespolina_option_group_created', 'success');
                $url = $this->container->get('router')->generate('vespolina_option_group_list');

                return new RedirectResponse($url);
            }
        }

        return $this->renderResponse('VespolinaCommerceBundle:OptionGroup:new.html', array(
            'form' => $form->createView(),
        ));
    }

    protected function renderResponse($template, $parameters)
    {
        return $this->container->get('templating')->renderResponse(
            sprintf('%s.%s', $template, $this->container->getParameter('vespolina.product.template_engine')),
            $parameters
        );
    }

    protected function setFlash($action, $value)
    {
        $this->container->get('session')->setFlash($action, $value);
    }
}
