<?php

namespace Omnipay\PaymentechOrbital\Message;

use SimpleXMLElement;

/**
 *  Paymentech Orbital Reversal Request
 */
class ReversalRequest extends AbstractRequest
{
    protected function xmlData()
    {
        $data = new SimpleXMLElement('<Request><Reversal></Reversal></Request>');
        $reversal = $data->Reversal;
        $reversal->OrbitalConnectionUsername = $this->getUsername();
        $reversal->OrbitalConnectionPassword = $this->getPassword();
        $reversal->TxRefNum                  = $this->getTxRefNum();
        $reversal->AdjustedAmt               = $this->getAmountInteger();
        $reversal->OrderID                   = $this->getOrderId();
        $reversal->BIN                       = $this->getBin();
        $reversal->MerchantID                = $this->getMerchantId();
        $reversal->TerminalID                = $this->getTerminalId();

        return $data;
    }

    public function getData()
    {
        $this->validate('txRefNum', 'orderId');
        return $this->xmlData()->asXML();
    }

    protected function createResponse($data)
    {
        if ($data->ReversalResp) {
            return $this->response = new ReversalResponse($this, $data);
        } elseif ($data->QuickResp) {
            return $this->response = new QuickResponse($this, $data);
        } else {
            throw new InvalidResponseException();
        }
    }
}
