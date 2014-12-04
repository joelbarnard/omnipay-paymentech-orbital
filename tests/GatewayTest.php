<?php

namespace Omnipay\PaymentechOrbital;

use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->initialize([
          'username'         => 'test',
          'password'         => 'test',
          'merchantId'       => 'test',
          'terminalId'       => '001',
          'industryType'     => 'EC',
          'bin'              => '000001',
          'testMode'         => true,
          'currencyCode'     => 840,
          'currencyExponent' => 2
        ]);
    }

    public function testPurchaseSuccess()
    {
        $this->setMockHttpResponse('PurchaseSuccess.txt');
        $request = $this->gateway->purchase([
          'amount' => '12.00',
          'orderId' => '123',
          'card'   => $this->getValidCard()
        ]);

        $this->assertInstanceOf('\Omnipay\PaymentechOrbital\Message\PurchaseRequest', $request);
        $this->assertSame('12.00', $request->getAmount());

        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertSame('5480BA96D9AED84530313C2DD9201256745B5416', $response->getTransactionReference());
        $this->assertTrue($response->isApproved());
        $this->assertSame('00', $response->getCode());
        $this->assertSame('Approved', $response->getMessage());
    }

    public function testAuthorize()
    {
        $request = $this->gateway->authorize([
          'amount' => '12.00',
          'card'   => $this->getValidCard()
        ]);

        $this->assertInstanceOf('\Omnipay\PaymentechOrbital\Message\AuthorizeRequest', $request);
        $this->assertSame('12.00', $request->getAmount());
    }

    public function testRefund()
    {
        $request = $this->gateway->refund([
          'amount' => '12.00',
          'card'   => $this->getValidCard()
        ]);

        $this->assertInstanceOf('\Omnipay\PaymentechOrbital\Message\RefundRequest', $request);
        $this->assertSame('12.00', $request->getAmount());
    }
}
