<?php

namespace Omnipay\PaymentechOrbital\Message;

use SimpleXMLElement;

/**
 *  Paymentech Orbital Refund Request
 */
class RefundRequest extends NewOrderRequest
{
    protected function getMessageType()
    {
        return 'R';
    }

    public function getData()
    {
        $this->validate('orderId');
        return parent::getData();
    }
}
