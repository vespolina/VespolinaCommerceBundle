<?php

namespace Vespolina\CommerceBundle\Form\Type\Cart;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Vespolina\CommerceBundle\Form\Type\Cart\CartProductType;

class CartItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('product', new CartProductType());
        $builder->add('quantity', 'integer', array('required' => true ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Vespolina\Entity\Order\Item',
            'cascade_validation' => true,
        ));
    }

    public function getName()
    {
        return 'item';
    }

}
