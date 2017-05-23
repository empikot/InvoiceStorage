<?php

namespace Piotrowm\InvoiceStorageBundle\Service;

use Piotrowm\InvoiceStorageBundle\Exception\OrderDataIsIncomplete;
use Piotrowm\InvoiceStorageBundle\Model\InvoiceHeader;

class InvoiceHeaderBuilder implements Builder
{
    const INVOICE_NUMBER_PREFIX = "FAV";

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
    public function __construct(NetPriceCalculator $netPriceCalculator, CustomerDataLoader $customerDataLoader)
    {

        $this->netPriceCalculator = $netPriceCalculator;
        $this->customerDataLoader = $customerDataLoader;
    }

    public function setOrderData(array $orderData) : self
    {
        $this->orderData = $orderData;
        return $this;
    }

    public function build() : self
    {
        $this->validateOrderHeaderData();

        $customerAddress = $this->customerDataLoader->findAddressById($this->orderData['customer_address_id']);
        $customerInvoiceData = $this->customerDataLoader->findInvoiceDataById($this->orderData['customer_invoice_data_id']);
        $this->invoiceHeader = new InvoiceHeader();
        $this->invoiceHeader->setOrderId($this->orderData['id'])
            ->setInvoiceNumber($this->generateInvoiceNumber($this->orderData['id']))
            ->setPaymentType($this->orderData['payment_type'])
            ->setGrossPriceSum($this->orderData['items_price'])
            ->setCustomerName($customerInvoiceData->getName() ? $customerInvoiceData->getName() : $customerAddress->getName())
            ->setCustomerStreet($customerAddress->getStreet())
            ->setCustomerZipCode($customerAddress->getZipCode())
            ->setCustomerCity($customerAddress->getCity())
            ->setCustomerTaxIdentifier($customerInvoiceData->getTaxIdentifier());
        return $this;
    }

    private function validateOrderHeaderData()
    {
        if (!isset($this->orderData['customer_address_id'])
            || !isset($this->orderData['customer_invoice_data_id'])
            || !isset($this->orderData['id'])
            || !isset($this->orderData['payment_type'])
            || !isset($this->orderData['items_price'])) {
            throw new OrderDataIsIncomplete("invalid order header data: ".json_encode($this->orderData));
        }
    }

    private function generateInvoiceNumber($orderId)
    {
        return self::INVOICE_NUMBER_PREFIX." ".$orderId;
    }

    public function getInvoiceHeader() : InvoiceHeader
    {
        return $this->invoiceHeader;
    }

}