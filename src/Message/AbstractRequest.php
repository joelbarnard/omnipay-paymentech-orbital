<?php

namespace Omnipay\PaymentechOrbital\Message;

/**
 *  Paymentech Orbital Abstract Request
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $retryCount = 0;

    protected $testUrls = array(
        'https://orbitalvar1.paymentech.net/authorize',
        'https://orbitalvar2.paymentech.net/authorize'
    );

    protected $liveUrls = array(
        'https://orbital1.paymentech.net/authorize',
        'https://orbital2.paymentech.net/authorize'
    );

    public function sendData($data)
    {
        $httpResponse = $this->httpClient->post(
            $this->getEndpoint(),
            $this->getHeaders(),
            $data,
            array('exceptions' => false)
        )
        ->send(); 
        return $this->createResponse($httpResponse->xml());
    }

    abstract protected function createResponse($data);

    protected function getHeaders()
    {

        return array(
            'MIME-Version' => '1.1',
            'Content-type' => 'Application/PTI52',
            'Content-transfer-encoding' => 'text',
            'Request-number' => '1',
            'Document-type' => 'Request',
            'Interface-Version' => 'ExtremeCMS 1.1',
            'Connection' => 'close'
        );
    }

    public function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint() : $this->liveEndpoint();
    }

    public function testEndpoint()
    {
        // TODO: retry logic
        return $this->testUrls[0];
    }

    public function liveEndpoint()
    {
        // TODO: retry logic
        return $this->liveUrls[0];
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

    public function getOrderId()
    {
        return $this->getParameter('orderId');
    }

    public function setOrderId($value)
    {
        return $this->setParameter('orderId', $value);
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

    public function getComments()
    {
        return $this->getParameter('comments');
    }

    public function setComments($value)
    {
        return $this->setParameter('comments', $value);
    }

    public function getTxRefNum()
    {
        return $this->getParameter('txRefNum');
    }

    public function setTxRefNum($value)
    {
        return $this->setParameter('txRefNum', $value);
    }
}
