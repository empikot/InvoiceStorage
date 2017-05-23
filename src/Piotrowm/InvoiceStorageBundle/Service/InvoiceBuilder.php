<?php

namespace Piotrowm\InvoiceStorageBundle\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Piotrowm\InvoiceStorageBundle\Model\InvoiceHeader;
use Symfony\Component\DependencyInjection\Container;

class InvoiceBuilder implements Builder
{
    const SHIPMENT_TAX_PERCENT = 23;

    /**
     * @var NetPriceCalculator
     */
    private $netPriceCalculator;
    /**
     * @var CustomerDataLoader
     */
    private $customerDataLoader;
    /**
     * @var ShipmentLoader
     */
    private $shipmentLoader;
    /**
     * @var ObjectManager
     */
    private $entityManager;
    /**
     * @var array
     */
    private $orderData;
    /**
     * @var InvoiceHeader
     */
    private $invoiceHeader;
    /**
     * @var array
     */
    private $invoiceLines;

    public function __construct(Container $serviceContainer, ObjectManager $entityManager)
    {
        $this->netPriceCalculator = $serviceContainer->get('piotrowm_invoice_storage.netPriceCalculator');
        $this->customerDataLoader = $serviceContainer->get('piotrowm_invoice_storage.customerDataLoader');
        $this->shipmentLoader = $serviceContainer->get('piotrowm_invoice_storage.shipmentLoader');
        $this->entityManager = $entityManager;
        $this->invoiceLines = array();
    }

    public function setOrderData(array $orderData) : self
    {
        $this->orderData = $orderData;
        return $this;
    }

    /**
     * @return InvoiceBuilder
     */
    public function build() : self
    {
        $this->buildInvoiceHeader();
        $this->createOrderLineForShipment();
        $this->buildInvoiceLines();
        return $this;
    }

    private function buildInvoiceHeader()
    {
        $headerBuilder = new InvoiceHeaderBuilder($this->netPriceCalculator, $this->customerDataLoader, $this->entityManager);
        $this->invoiceHeader = $headerBuilder->setOrderData($this->orderData)->build()->getInvoiceHeader();
    }

    private function createOrderLineForShipment()
    {
        $this->addShipmentGrossPriceToGrossPriceSum($this->orderData['shipment_price']);
        $shipmentProductId = $this->shipmentLoader->getShipmentIdBySymbol($this->orderData['shipment_type']);
        $this->orderData['lines'][] = array(
            'id' => null,
            'order_id' => $this->orderData['id'],
            'product_id' => $shipmentProductId,
            'quantity' => 1,
            'gross_price' => $this->orderData['shipment_price'],
            'tax_percent' => self::SHIPMENT_TAX_PERCENT
        );
    }

    private function addShipmentGrossPriceToGrossPriceSum($grossShipmentPrice)
    {
        $grossPriceSum = $this->invoiceHeader->getGrossPriceSum();
        $this->invoiceHeader->setGrossPriceSum($grossPriceSum + $grossShipmentPrice);
    }

    private function buildInvoiceLines()
    {
        $lineBuilder = new InvoiceLineBuilder($this->netPriceCalculator);
        foreach ($this->orderData['lines'] as $orderLine) {
            $this->invoiceLines[] = $lineBuilder->setOrderLineData($orderLine)->build()->getInvoicLine();
        }
    }

    public function getInvoice() : InvoiceHeader
    {
        foreach ($this->invoiceLines as $invoiceLine) {
            $invoiceLine->setInvoiceId($this->invoiceHeader);
            $this->invoiceHeader->addInvoiceLine($invoiceLine);
        }
        return $this->invoiceHeader;
    }
}