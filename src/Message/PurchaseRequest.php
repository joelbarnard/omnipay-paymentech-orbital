<?php

namespace Omnipay\PaymentechOrbital\Message;

use SimpleXMLElement;

/**
 *  Paymentech Orbital Purchase Request
 */
class PurchaseRequest extends NewOrderRequest
{
    protected function getMessageType() {
        return 'AC';
    }

    public function getData()
    {
        $this->validate('amount');
        return parent::getData();
    }
}
