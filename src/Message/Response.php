<?php

namespace Omnipay\PaymentechOrbital\Message;

use SimpleXMLElement;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

/**
 *  Paymentech Orbital Response
 */
class Response extends AbstractResponse
{
    public function isSuccessful()
    {
        return $this->data->NewOrderResp->ProcStatus == '0';
    }
}
