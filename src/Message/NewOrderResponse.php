<?php

namespace Omnipay\PaymentechOrbital\Message;

use SimpleXMLElement;
use Omnipay\Common\Message\AbstractResponse;

/**
 *  Paymentech Orbital Response
 */
class NewOrderResponse extends AbstractResponse
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

    public function isSuccessful()
    {
        return $this->data->NewOrderResp->ProcStatus == '0';
    }
}
