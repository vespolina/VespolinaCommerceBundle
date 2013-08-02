<?php
/**
 * (c) Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\CommerceBundle\Form\Type\Partner;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;

class SimpleContactType extends AbstractType
{
    /**
     * @var string
     */
    private $dataClass;

    public function __construct($dataClass)
    {
        $this->dataClass = $dataClass;
    }

    public function getName()
    {
        return 'vespolina_commerce_simple_contact';
    }
    
    public function buildForm(FormBuilderInterface $formBuilder, array $options)
    {
        $formBuilder
            ->add('email', null, array('required' => true))
           ;
    }
    
    public function getDefaultOptions(array $options = array())
    {
        return array(
            'data_class' => $this->dataClass,
        );
    }
}