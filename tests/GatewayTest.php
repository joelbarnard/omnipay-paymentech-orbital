<?php

namespace Omnipay\PaymentechOrbital;

use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->initialize(array(
          'username'         => 'test',
          'password'         => 'test',
          'merchantId'       => 'test',
          'terminalId'       => '001',
          'industryType'     => 'EC',
          'bin'              => '000001',
          'testMode'         => true,
          'currencyCode'     => 840,
          'currencyExponent' => 2
        ));
    }

    public function testPurchaseSuccess()
    {
        $this->setMockHttpResponse('PurchaseSuccess.txt');
        $request = $this->gateway->purchase(array(
          'amount' => '12.00',
          'orderId' => '123',
          'card'   => $this->getValidCard()
        ));

        $this->assertInstanceOf('\Omnipay\PaymentechOrbital\Message\PurchaseRequest', $request);
        $this->assertSame('12.00', $request->getAmount());

        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertSame('5480BA96D9AED84530313C2DD9201256745B5416', $response->getTransactionReference());
        $this->assertTrue($response->isApproved());
        $this->assertSame('00', $response->getCode());
        $this->assertSame('Approved', $response->getMessage());
    }

    public function testPurchaseError()
    {
        $this->setMockHttpResponse('ErrorResponse.txt');
        $card = $this->getValidCard();
        $card['number'] = 'zzz';
        $request = $this->gateway->purchase(array(
          'amount' => '12.00',
          'orderId' => '123',
          'card'   => $card
        ));

        $this->assertInstanceOf('\Omnipay\PaymentechOrbital\Message\PurchaseRequest', $request);
        $this->assertSame('12.00', $request->getAmount());

        $response = $request->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertSame('Error validating card/account number range', $response->getMessage());
    }

    public function testAuthorizeSuccess()
    {
        $this->setMockHttpResponse('AuthorizeSuccess.txt');
        $request = $this->gateway->authorize(array(
          'amount' => '12.00',
          'orderId' => '123',
          'card'   => $this->getValidCard()
        ));

        $this->assertInstanceOf('\Omnipay\PaymentechOrbital\Message\AuthorizeRequest', $request);
        $this->assertSame('12.00', $request->getAmount());

        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertSame('5480C67F9F583EEF09E06A4EE56657744A88541A', $response->getTransactionReference());
        $this->assertTrue($response->isApproved());
        $this->assertSame('00', $response->getCode());
        $this->assertSame('Approved', $response->getMessage());
    }

    public function testRefundSuccess()
    {
        $this->setMockHttpResponse('RefundSuccess.txt');
        $request = $this->gateway->refund(array(
          'amount' => '12.00',
          'orderId' => '123',
          'card'   => $this->getValidCard()
        ));

        $this->assertInstanceOf('\Omnipay\PaymentechOrbital\Message\RefundRequest', $request);
        $this->assertSame('12.00', $request->getAmount());

        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertSame('5480C780809EEFBC09213F79CEA968BDEE0954AD', $response->getTransactionReference());
        $this->assertTrue($response->isApproved());
    }

    public function testRefundTxSuccess()
    {
        $this->setMockHttpResponse('RefundTxSuccess.txt');
        $request = $this->gateway->refund(array(
          'amount' => '12.00',
          'orderId' => '123',
          'txRefNum' => '5480D0B04F73526665D2357BAF54586DA27654E9'
        ));

        $this->assertInstanceOf('\Omnipay\PaymentechOrbital\Message\RefundRequest', $request);
        $this->assertSame('12.00', $request->getAmount());

        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertSame('5480DBB1662A5CC673A443AEA264698837FD5499', $response->getTransactionReference());
        $this->assertTrue($response->isApproved());
    }

    public function testCaptureLockedDown()
    {
        $this->setMockHttpResponse('CaptureLockedDown.txt');
        $request = $this->gateway->capture(array(
          'amount' => '12.00',
          'orderId' => '123',
          'txRefNum' => 'abc'
        ));

        $this->assertInstanceOf('\Omnipay\PaymentechOrbital\Message\MarkForCaptureRequest', $request);
        $this->assertSame('12.00', $request->getAmount());

        $response = $request->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertSame('This transaction is locked down. You cannot mark or unmark it.', $response->getMessage());
    }

    public function testCaptureSuccess()
    {
        $this->setMockHttpResponse('CaptureSuccess.txt');
        $request = $this->gateway->capture(array(
          'amount' => '1.00',
          'orderId' => '123',
          'txRefNum' => '5481FDB3206618C4C114E587D23A16FCF10C5396'
        ));

        $this->assertInstanceOf('\Omnipay\PaymentechOrbital\Message\MarkForCaptureRequest', $request);
        $this->assertSame('1.00', $request->getAmount());

        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertSame('5481FDB3206618C4C114E587D23A16FCF10C5396', $response->getTransactionReference());
        $this->assertTrue($response->isApproved());
        $this->assertSame('100', $response->getAmount());
    }

    public function testReversalSuccess()
    {
        $this->setMockHttpResponse('ReversalSuccess.txt');
        $request = $this->gateway->void(array(
          'amount' => '1.00',
          'orderId' => '123',
          'txRefNum' => '5487548B68A57AB7CA37FAA92253F3EBC3D953DE'
        ));

        $this->assertInstanceOf('\Omnipay\PaymentechOrbital\Message\ReversalRequest', $request);
        $this->assertSame('1.00', $request->getAmount());

        $response = $request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertSame('5487548B68A57AB7CA37FAA92253F3EBC3D953DE', $response->getTransactionReference());
    }

    public function testReversalInvalidAmount()
    {
        $this->setMockHttpResponse('ReversalInvalidAmount.txt');
        $request = $this->gateway->void(array(
          'amount' => '11.00',
          'orderId' => '123',
          'txRefNum' => '5487548B68A57AB7CA37FAA92253F3EBC3D953DE'
        ));

        $this->assertInstanceOf('\Omnipay\PaymentechOrbital\Message\ReversalRequest', $request);
        $this->assertSame('11.00', $request->getAmount());

        $response = $request->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertSame('The amount requested is invalid. Requested: 1100, Allowed: 600.', $response->getMessage());
    }
}
