<?php

namespace Omnipay\PaymentechOrbital;

use Omnipay\Common\AbstractGateway;

/**
 * Paymentech Orbital Gateway
 *
 * @link https://secure.paymentech.com/developercenter/pages/home
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Paymentech Orbital';
    }

    public function getDefaultParameters()
    {
        return array(
            'username'         => '',
            'password'         => '',
            'merchantId'       => '',
            'terminalId'       => '',
            'industryType'     => '',
            'bin'              => '',
            'testMode'         => false,
            'currencyCode'     => 0,
            'currencyExponent' => 0
        );
    }

    public function getUsername()
    {
        return $this->getParameter('username');
    }

    public function setUsername($value)
    {
        return $this->setParameter('username', $value);
    }

    public function getPassword()
    {
        return $this->getParameter('password');
    }

    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }

    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    public function getTerminalId()
    {
        return $this->getParameter('terminalId');
    }

    public function setTerminalId($value)
    {
        return $this->setParameter('terminalId', $value);
    }

    public function getIndustryType()
    {
        return $this->getParameter('industryType');
    }

    public function setIndustryType($value)
    {
        return $this->setParameter('industryType', $value);
    }

    public function getBin()
    {
        return $this->getParameter('bin');
    }

    public function setBin($value)
    {
        return $this->setParameter('bin', $value);
    }

    public function getCurrencyCode()
    {
        return $this->getParameter('currencyCode');
    }

    public function setCurrencyCode($value)
    {
        return $this->setParameter('currencyCode', $value);
    }

    public function getCurrencyExponent()
    {
        return $this->getParameter('currencyExponent');
    }

    public function setCurrencyExponent($value)
    {
        return $this->setParameter('currencyExponent', $value);
    }

    public function getTestMode()
    {
        return $this->getParameter('testMode');
    }

    public function setTestMode($value)
    {
        return $this->setParameter('testMode', $value);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\PaymentechOrbital\Message\PurchaseRequest', $parameters);
    }

    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\PaymentechOrbital\Message\AuthorizeRequest', $parameters);
    }

    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\PaymentechOrbital\Message\RefundRequest', $parameters);
    }

    public function capture(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\PaymentechOrbital\Message\MarkForCaptureRequest', $parameters);
    }

    public function void(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\PaymentechOrbital\Message\ReversalRequest', $parameters);
    }
}
