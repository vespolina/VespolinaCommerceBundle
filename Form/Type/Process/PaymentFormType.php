<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\CommerceBundle\Form\Type\Process;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Quickly create a customer
 *
 * @author Daniel Kucharski <daniel@xerias.be>
 */
class PaymentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number', 'text', array(
                'label' => 'Card Number'
            )
//            ->add()
        );
    }

    public function getName()
    {
        return 'vespolina_store_payment';
    }
}
