<?php

namespace Omnipay\PaymentechOrbital\Message;

use SimpleXMLElement;

/**
 *  Paymentech Orbital Response
 */
class NewOrderResponse extends Response
{
    public function getTransactionReference()
    {
        return $this->data->NewOrderResp->TxRefNum->__toString();
    }

    public function isApproved()
    {
        return $this->data->NewOrderResp->ApprovalStatus == '1';
    }

    public function getCode()
    {
        return $this->data->NewOrderResp->RespCode->__toString();
    }

    public function getMessage()
    {
        return $this->data->NewOrderResp->StatusMsg->__toString();
    }
}
