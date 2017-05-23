<?php

namespace Piotrowm\InvoiceStorageBundle\Tests\Service;

use PHPUnit\Framework\TestCase;
use Piotrowm\InvoiceStorageBundle\Service\InvoiceLineBuilder;
use Piotrowm\InvoiceStorageBundle\Service\NetPriceCalculator;

class InvoiceLineBuilderTest extends TestCase
{
    private $invoiceLineBuilder;
    private $validData = array(
        'id' => 101,
        'order_id' => 1,
        'product_id' => 12345,
        'quantity' => 1,
        'gross_price' => 200.00,
        'tax_percent' => 23,
        'net_price' => 162.60,
    );
    private $validData2 = array(
        'id' => 101,
        'order_id' => 1,
        'product_id' => 12345,
        'quantity' => 2,
        'gross_price' => 117.45,
        'tax_percent' => 23,
        'net_price' => 95.5,
    );
    private $invalidData = array(
        'id' => 101,
        'order_id' => 1,
        'product_id' => 12345,
        'quantity' => 1,
        'gross_price' => -54.00,
        'tax_percent' => 8
    );
    private $emptyData = array();

    public function setUp()
    {
        $this->invoiceLineBuilder = new InvoiceLineBuilder(new NetPriceCalculator());
    }

    public function testValidOrderData()
    {
        $invoiceLine = $this->invoiceLineBuilder->setOrderLineData($this->validData)->build()->getInvoiceLine();
        $this->assertCloseEnough($this->validData['gross_price'], $invoiceLine->getGrossPrice());
        $this->assertCloseEnough($this->validData['net_price'], $invoiceLine->getNetPrice());
        $this->assertCloseEnough($this->validData['gross_price'] / $this->validData['quantity'], $invoiceLine->getGrossPriceItem());
        $this->assertCloseEnough($this->validData['net_price'] / $this->validData['quantity'], $invoiceLine->getNetPriceItem());

        $invoiceLine = $this->invoiceLineBuilder->setOrderLineData($this->validData2)->build()->getInvoiceLine();
        $this->assertCloseEnough($this->validData2['gross_price'], $invoiceLine->getGrossPrice());
        $this->assertCloseEnough($this->validData2['net_price'], $invoiceLine->getNetPrice());
        $this->assertCloseEnough($this->validData2['gross_price'] / $this->validData2['quantity'], $invoiceLine->getGrossPriceItem());
        $this->assertCloseEnough($this->validData2['net_price'] / $this->validData2['quantity'], $invoiceLine->getNetPriceItem());
    }

    /**
     * rounds expected value to at most 2 decimal places and then assertEquals
     * @param float $expected
     * @param float $actual
     */
    private function assertCloseEnough(float $expected, float $actual) {
        $this->assertEquals(round($expected, 2), $actual);
    }

    public function testInvalidOrderData()
    {
        $this->expectException("Piotrowm\InvoiceStorageBundle\Exception\GrossPriceCannotBeNegative");
        $this->invoiceLineBuilder->setOrderLineData($this->invalidData)->build()->getInvoiceLine();
    }

    public function testEmptyOrderData()
    {
        $this->expectException("Piotrowm\InvoiceStorageBundle\Exception\OrderDataIsIncomplete");
        $this->invoiceLineBuilder->setOrderLineData($this->emptyData)->build()->getInvoiceLine();
    }
}