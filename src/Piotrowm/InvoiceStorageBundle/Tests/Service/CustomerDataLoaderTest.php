<?php
namespace Piotrowm\InvoiceStorageBundle\Tests\Service;

use PHPUnit\Framework\TestCase;
use Piotrowm\InvoiceStorageBundle\Service\CustomerDataLoader;

class CustomerDataLoaderTest extends TestCase
{
    public function testCustomerAddressExists()
    {
        $loader = new CustomerDataLoader();
        $address = $loader->findAddressById(1);
        $this->assertEquals(1, $address->getId());
    }

    public function testCustomerAddressDoesntExist()
    {
        $loader = new CustomerDataLoader();

        $this->expectException("Piotrowm\InvoiceStorageBundle\Exception\CustomerAddressDoesntExist");
        $loader->findAddressById(9999);
    }

    public function testCustomerInvoiceDataExists()
    {
        $loader = new CustomerDataLoader();
        $invoiceData = $loader->findInvoiceDataById(1);
        $this->assertEquals(1, $invoiceData->getId());
    }

    public function testCustomerInfoiveDataDoesntExist()
    {
        $loader = new CustomerDataLoader();

        $this->expectException("Piotrowm\InvoiceStorageBundle\Exception\CustomerInvoiceDataDoesntExist");
        $loader->findInvoiceDataById(9999);
    }
}