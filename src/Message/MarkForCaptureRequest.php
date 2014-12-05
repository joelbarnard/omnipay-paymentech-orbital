<?php

namespace Omnipay\PaymentechOrbital\Message;

use SimpleXMLElement;

/**
 *  Paymentech Orbital Mark for Capture Request
 */
class MarkForCaptureRequest extends AbstractRequest
{
    protected function xmlData()
    {
        $data = new SimpleXMLElement('<Request><MarkForCapture></MarkForCapture></Request>');
        $markForCapture = $data->MarkForCapture;
        $markForCapture->OrbitalConnectionUsername = $this->getUsername();
        $markForCapture->OrbitalConnectionPassword = $this->getPassword();
        $markForCapture->OrderID                   = $this->getOrderId();
        $markForCapture->Amount                    = $this->getAmountInteger();
        $markForCapture->BIN                       = $this->getBin();
        $markForCapture->MerchantID                = $this->getMerchantId();
        $markForCapture->TerminalID                = $this->getTerminalId();
        $markForCapture->TxRefNum                  = $this->getTxRefNum();

        return $data;
    }

    public function getData()
    {
        $this->validate('txRefNum', 'orderId');
        return $this->xmlData()->asXML();
    }

    protected function createResponse($data)
    {
      print_r($data);
        if ($data->MarkForCaptureResp) {
            return $this->response = new MarkForCaptureResponse($this, $data);
        } elseif ($data->QuickResp) {
            return $this->response = new QuickResponse($this, $data);
        } else {
            throw new InvalidResponseException();
        }
    }
}
