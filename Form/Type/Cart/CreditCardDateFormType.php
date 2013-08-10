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
class CreditCardDateFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('month', 'choice', array(
                'choices' => $this->getMonthChoices(),
                'required' => true,
            ))
            ->add('year', 'choice', array(
                'choices' => $this->getYearChoices(),
                'required' => true,
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
        return 'v_creditcard_date';
    }

    protected function getMonthChoices()
    {
        // todo: make configurable for format
        $months = array();
        for ($m = 1 ; $m <= 12 ; $m++) {
            $mo = sprintf('%02d', $m);
            $months[$mo] = $mo;
        }
        return $months;
    }

    protected function getYearChoices()
    {
        // todo: make configurable for range and format
        $startingYear = (integer)date('y');
        $endingYear = $startingYear + 25;
        $key = (integer)date('Y');
        $years = array();
        for ($y = (string)$startingYear ; $y <= (string)$endingYear ; $y++) {
            $years[$key] = $y;
            $key++;
        }
        return $years;
    }
}
