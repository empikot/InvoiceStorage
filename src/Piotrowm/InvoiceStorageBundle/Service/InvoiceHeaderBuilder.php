<?php

namespace Piotrowm\InvoiceStorageBundle\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Piotrowm\InvoiceStorageBundle\Model\InvoiceHeader;

class InvoiceHeaderBuilder implements Builder
{
    /**
     * @var array
     */
    private $orderData;
    /**
     * @var InvoiceHeader
     */
    private $invoiceHeader;
    /**
     * @var NetPriceCalculator
     */
    private $netPriceCalculator;
    /**
     * @var CustomerDataLoader
     */
    private $customerDataLoader;
    /**
     * @var ObjectManager
     */
    private $entityManager;

    public function __construct(NetPriceCalculator $netPriceCalculator, CustomerDataLoader $customerDataLoader, ObjectManager $entityManager)
    {

        $this->netPriceCalculator = $netPriceCalculator;
        $this->customerDataLoader = $customerDataLoader;
        $this->entityManager = $entityManager;
    }

    public function setOrderData(array $orderData) : self
    {
        $this->orderData = $orderData;
        return $this;
    }

    public function build() : self
    {
        $customerAddress = $this->customerDataLoader->findAddressById($this->orderData['customer_address_id']);
        $customerInvoiceData = $this->customerDataLoader->findInvoiceDataById($this->orderData['customer_invoice_data_id']);
        $this->invoiceHeader = new InvoiceHeader();
        $this->invoiceHeader->setOrderId($this->orderData['id2'])
            ->setInvoiceNumber('F/1/2017')
            ->setPaymentType($this->orderData['payment_type'])
            ->setGrossPriceSum($this->orderData['items_price'])
            ->setCustomerName($customerInvoiceData->getName() ? $customerInvoiceData->getName() : $customerAddress->getName())
            ->setCustomerStreet($customerAddress->getStreet())
            ->setCustomerZipCode($customerAddress->getZipCode())
            ->setCustomerCity($customerAddress->getCity())
            ->setCustomerTaxIdentifier($customerInvoiceData->getTaxIdentifier());
        return $this;
    }

    public function getInvoiceHeader() : InvoiceHeader
    {
        return $this->invoiceHeader;
    }

}