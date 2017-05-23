<?php

namespace Piotrowm\InvoiceStorageBundle\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Piotrowm\InvoiceStorageBundle\Model\InvoiceHeader;
use Symfony\Component\Debug\Exception\ContextErrorException;
use Symfony\Component\DependencyInjection\Container;

class InvoiceBuilder implements Builder
{
    private $netPriceCalculator;
    private $customerDataLoader;
    private $shipmentLoader;
    private $entityManager;
    private $orderData;
    private $invoiceHeader;
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
        try {
            $this->buildInvoiceHeader();
            $this->createOrderLineForShipment();
            $this->buildInvoiceLines();
        } catch (ContextErrorException $ex) {
            die($ex->getMessage());
            //throw $ex;
        }
        return $this;
    }

    private function buildInvoiceHeader()
    {
        $headerBuilder = new InvoiceHeaderBuilder($this->netPriceCalculator, $this->customerDataLoader, $this->entityManager);
        $this->invoiceHeader = $headerBuilder->setOrderData($this->orderData)->build()->getInvoiceHeader();
    }

    private function createOrderLineForShipment()
    {
        $shipmentProductId = $this->shipmentLoader->getShipmentIdBySymbol($this->orderData['shipment_type']);
        $this->orderData['lines'][] = array(
            'id' => null,
            'order_id' => $this->orderData['id'],
            'product_id' => $shipmentProductId,
            'quantity' => 1,
            'gross_price' => $this->orderData['shipment_price'],
            'tax_percent' => 23
        );
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