<?php

namespace Omnipay\PaymentechOrbital\Message;

use SimpleXMLElement;

/**
 *  Paymentech Orbital Authorize Request
 */
class AuthorizeRequest extends NewOrderRequest
{
    protected function getMessageType() {
        return 'A';
    }

    public function getData()
    {
        $this->validate('amount', 'card');
        return parent::getData();
    }
}
