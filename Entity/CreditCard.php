<?php

namespace Vespolina\CommerceBundle\Entity;

use Omnipay\Common\CreditCard as BaseCreditCard;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CreditCard
 *
 * Used to populate the underlying Omnipay class and to also validate the class
 * using Symfony2 validation
 *
 * @package Vespolina\CommerceBundle
 */
class CreditCard extends BaseCreditCard
{
    /**
     * @Assert\CardScheme(schemes = {"VISA"}, message = "Your credit card number is invalid.")
     */
    protected $number;

    protected $expiryMonth;

    protected $expiryYear;

    public function setExpiryMonth($expiryMonth)
    {
        parent::setExpiryMonth($expiryMonth);
        $this->expiryMonth = $expiryMonth;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getExpiryMonth()
    {
        return $this->expiryMonth;
    }

    public function setExpiryYear($expiryYear)
    {
        parent::setExpiryYear($expiryYear);
        $this->expiryYear = $expiryYear;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getExpiryYear()
    {
        return $this->expiryYear;
    }

    public function setNumber($number)
    {
        parent::setNumber($number);
        $this->number = $number;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }
} 