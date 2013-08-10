<?php

/**
 * (c) 2012 Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\CommonBundle\Form\Type\Cart;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

/**
 * @author Richard Shank <develop@zestic.com>
 */
class CreditCardFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('cardNumber', 'text', array(
                'required' => true,
                'label' => 'Card Number',
                'attr' => array(
                    'size' => '24',
                    'maxlength' => '24',
                    'onblur' => "cc=this.value;this.value=this.value.replace(/[^\d]/g, '');",
                    'onfocus' => "if(this.value!=cc)this.value=cc;",
                ),
            ))
            ->add('expiration', new CreditCardDateFormType(), array(
                'required' => true,
                'label' => 'Expiration Date',
            ))
            ->add('cvv', 'text', array(
                'required' => false,
                'label' => 'CVV',
                'attr' => array(
                    'size' => '4',
                ),
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent(array $options)
    {
        return 'field';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'v_creditcard';
    }
}
