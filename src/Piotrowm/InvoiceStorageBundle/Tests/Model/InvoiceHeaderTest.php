<?php

namespace Piotrowm\InvoiceStorageBundle\Tests\Model;

use PHPUnit\Framework\TestCase;
use Piotrowm\InvoiceStorageBundle\Model\InvoiceHeader;
use Piotrowm\InvoiceStorageBundle\Model\InvoiceLine;

class InvoiceHeaderTest extends TestCase
{
    public function testAdd()
    {
        $header = new InvoiceHeader();
        $line1 = new InvoiceLine();
        $line1->setNetPrice(20);
        $header->addInvoiceLine($line1);
        $this->assertEquals(20, $header->getNetPriceSum());

        $line2 = new InvoiceLine();
        $line2->setNetPrice(15);
        $header->addInvoiceLine($line2);
        $this->assertEquals(35, $header->getNetPriceSum());
    }

    public function testRemove()
    {
        $header = new InvoiceHeader();
        $line1 = new InvoiceLine();
        $line1->setNetPrice(0);
        $header->removeInvoiceLine($line1);
        $this->assertEquals(null, $header->getNetPriceSum());
    }

    public function testAddThenRemove()
    {
        $header = new InvoiceHeader();
        $line1 = new InvoiceLine();
        $line1->setNetPrice(20);
        $header->addInvoiceLine($line1);
        $this->assertEquals(20, $header->getNetPriceSum());

        $header->removeInvoiceLine($line1);
        $this->assertEquals(0, $header->getNetPriceSum());
    }

    public function testNegativePrice()
    {
        $header = new InvoiceHeader();
        $line1 = new InvoiceLine();
        $line1->setNetPrice(20);
        $header->addInvoiceLine($line1);
        $this->assertEquals(20, $header->getNetPriceSum());

        $line2 = new InvoiceLine();
        $line2->setNetPrice(-15);
        $header->addInvoiceLine($line2);
        $this->assertEquals(5, $header->getNetPriceSum());

        $header->removeInvoiceLine($line2);
        $this->assertEquals(20, $header->getNetPriceSum());
    }
}