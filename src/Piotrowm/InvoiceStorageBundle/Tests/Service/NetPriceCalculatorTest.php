<?php

namespace Piotrowm\InvoiceStorageBundle\Tests\Service;

use PHPUnit\Framework\TestCase;
use Piotrowm\InvoiceStorageBundle\Service\NetPriceCalculator;

class NetPriceCalculatorTest extends TestCase
{
    public function testCorrectCase()
    {
        $calculator = new NetPriceCalculator();
        $netPrice = $calculator->calculateNetPrice(123, 23);
        $this->assertEquals(100, $netPrice);

        $netPrice = $calculator->calculateNetPrice(54, 8);
        $this->assertEquals(50, $netPrice);

        $netPrice = $calculator->calculateNetPrice(412, 23);
        $this->assertEquals(334.96, $netPrice);
    }

    public function testUnreasonableTax()
    {
        $calculator = new NetPriceCalculator();

        $this->expectException("Piotrowm\InvoiceStorageBundle\Exception\TaxValueMustBeReasonable");
        $calculator->calculateNetPrice(123, -1);

        $this->expectException("Piotrowm\InvoiceStorageBundle\Exception\TaxValueMustBeReasonable");
        $calculator->calculateNetPrice(54, 101);
    }

    public function testNegativeNetPrice()
    {
        $calculator = new NetPriceCalculator();

        $this->expectException("Piotrowm\InvoiceStorageBundle\Exception\GrossPriceCannotBeNegative");
        $calculator->calculateNetPrice(-123, 23);
    }

    public function testTaxFreeCase()
    {
        $calculator = new NetPriceCalculator();
        $netPrice = $calculator->calculateNetPrice(217.03, 0);
        $this->assertEquals(217.03, $netPrice);
    }
}