<?php

namespace Piotrowm\InvoiceStorageBundle\Tests\Service;

use PHPUnit\Framework\TestCase;
use Piotrowm\InvoiceStorageBundle\Service\CustomerDataLoader;
use Piotrowm\InvoiceStorageBundle\Service\InvoiceBuilder;
use Piotrowm\InvoiceStorageBundle\Service\NetPriceCalculator;
use Piotrowm\InvoiceStorageBundle\Service\ShipmentLoader;

class InvoiceBuilderTest extends TestCase
{
    private $invoiceBuilder;
    private $validData = array(
        'id' => 1,
        'status' => 'zrealizowane',
        'customer_address_id' => 1,
        'customer_invoice_data_id' => 1,
        'shipment_type' => 'SM_INPOST',
        'shipment_price' => 12.00,
        'payment_type' => 'PM_PAYU',
        'items_price' => 0.00,
        'lines' => array(),
    );
    private $invalidData = array(
        'id' => 1,
        'status' => 'zrealizowane',
        'customer_address_id' => 1,
        'customer_invoice_data_id' => 1,
        'shipment_type' => 'SM_INPOST',
        'payment_type' => 'PM_PAYU',
        'items_price' => 0.00,
        'lines' => array(),
    );

    public function setUp()
    {
        $this->invoiceBuilder = new InvoiceBuilder(new NetPriceCalculator(), new CustomerDataLoader(), new ShipmentLoader());
    }

    public function testValidData()
    {
        $invoice = $this->invoiceBuilder->setOrderData($this->validData)->build()->getInvoice();
        $this->assertEquals($this->validData['shipment_price'], $invoice->getGrossPriceSum());
        $this->assertEquals(9.76, $invoice->getNetPriceSum());

        $invoiceLines = $invoice->getInvoiceLines();
        $this->assertEquals($this->validData['shipment_price'], $invoiceLines[0]->getGrossPrice());
    }

    public function testInvalidData()
    {
        $this->expectException("Piotrowm\InvoiceStorageBundle\Exception\OrderDataIsIncomplete");
        $this->invoiceBuilder->setOrderData($this->invalidData)->build()->getInvoice();
    }
}