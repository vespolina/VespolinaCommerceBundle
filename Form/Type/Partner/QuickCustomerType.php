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
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class QuickCustomerType extends AbstractType
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
        return 'quick_customer';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('personalDetails', 'vespolina_commerce_personal_details', array(
                    'mapped'	=> true)
            )
            ->add('primaryContact', 'vespolina_commerce_simple_contact', array(
                'mapped'	=> false)
            )
            ->add('address', 'vespolina_commerce_address', array(
                'mapped'	=> false,
            )
        );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => $this->dataClass,
            ));
    }

}