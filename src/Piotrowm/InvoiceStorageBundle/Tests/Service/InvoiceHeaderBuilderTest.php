<?php

namespace Piotrowm\InvoiceStorageBundle\Tests\Service;

use PHPUnit\Framework\TestCase;
use Piotrowm\InvoiceStorageBundle\Service\CustomerDataLoader;
use Piotrowm\InvoiceStorageBundle\Service\InvoiceHeaderBuilder;
use Piotrowm\InvoiceStorageBundle\Service\NetPriceCalculator;

class InvoiceHeaderBuilderTest extends TestCase
{
    private $invoiceHeaderBuilder;
    private $validData = array(
        'id' => 1,
        'status' => 'zrealizowane',
        'customer_address_id' => 1,
        'customer_invoice_data_id' => 1,
        'shipment_type' => 'SM_INPOST',
        'shipment_price' => 12.00,
        'payment_type' => 'PM_PAYU',
        'items_price' => 177.00,
        'lines' => array(),
    );
    private $invalidData = array(
        'id' => 1,
        'status' => 'zrealizowane',
        'customer_address_id' => 1,
        'customer_invoice_data_id' => -1,
        'shipment_type' => '',
        'shipment_price' => 12.00,
        'payment_type' => 'PM_PAYU',
        'items_price' => 177.00,
        'lines' => array(),
    );
    private $emptyData = array();

    public function setUp()
    {
        $this->invoiceHeaderBuilder = new InvoiceHeaderBuilder(new NetPriceCalculator(), new CustomerDataLoader());
    }

    public function testValidOrderData()
    {
        $invoiceHeader = $this->invoiceHeaderBuilder->setOrderData($this->validData)->build()->getInvoiceHeader();
        $this->assertEquals($this->validData['payment_type'], $invoiceHeader->getPaymentType());
        $this->assertEquals($this->validData['items_price'], $invoiceHeader->getGrossPriceSum());
        $this->assertContains((string)$this->validData['id'], $invoiceHeader->getCustomerTaxIdentifier());
    }

    public function testInvalidOrderData()
    {
        $this->expectException("Piotrowm\InvoiceStorageBundle\Exception\CustomerInvoiceDataDoesntExist");
        $this->invoiceHeaderBuilder->setOrderData($this->invalidData)->build()->getInvoiceHeader();
    }

    public function testEmptyOrderData()
    {
        $this->expectException("Piotrowm\InvoiceStorageBundle\Exception\OrderDataIsIncomplete");
        $this->invoiceHeaderBuilder->setOrderData($this->emptyData)->build()->getInvoiceHeader();
    }
}