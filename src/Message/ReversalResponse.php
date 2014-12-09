<?php

namespace Omnipay\PaymentechOrbital\Message;

use SimpleXMLElement;
use Omnipay\Common\Message\AbstractResponse;

/**
 *  Paymentech Orbital Reversal Response
 */
class ReversalResponse extends AbstractResponse
{
    public function getTransactionReference()
    {
        return $this->data->ReversalResp->TxRefNum->__toString();
    }

    public function getCode()
    {
        return $this->data->ReversalResp->ProcStatus->__toString();
    }

    public function getMessage()
    {
        return $this->data->ReversalResp->StatusMsg->__toString();
    }

    public function isSuccessful()
    {
        return $this->data->ReversalResp->ProcStatus == '0';
    }
}
