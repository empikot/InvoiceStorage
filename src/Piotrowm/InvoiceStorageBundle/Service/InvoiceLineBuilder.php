<?php

namespace Piotrowm\InvoiceStorageBundle\Service;

use Piotrowm\InvoiceStorageBundle\Model\InvoiceLine;

class InvoiceLineBuilder implements Builder
{
    /**
     * @var array
     */
    private $orderLineData;
    /**
     * @var InvoiceLine
     */
    private $invoiceLine;
    /**
     * @var NetPriceCalculator
     */
    private $netPriceCalculator;

    public function __construct(NetPriceCalculator $netPriceCalculator)
    {

        $this->netPriceCalculator = $netPriceCalculator;
    }

    public function setOrderLineData(array $orderLineData) : self
    {
        $this->orderLineData = $orderLineData;
        return $this;
    }

    public function build() : self
    {
        $this->invoiceLine = new InvoiceLine();
        $this->invoiceLine->setProductId($this->orderLineData['product_id'])
            ->setQuantity($this->orderLineData['quantity'])
            ->setGrossPriceItem(round($this->orderLineData['gross_price'] / $this->orderLineData['quantity'], 2))
            ->setGrossPrice($this->orderLineData['gross_price'])
            ->setTaxPercent($this->orderLineData['tax_percent']);
        $netPriceItem = $this->netPriceCalculator->calculateNetPrice($this->invoiceLine->getGrossPriceItem(), $this->invoiceLine->getTaxPercent());
        $this->invoiceLine->setNetPriceItem($netPriceItem);
        $this->invoiceLine->setNetPrice($netPriceItem * $this->orderLineData['quantity']);
        return $this;
    }

    public function getInvoicLine() : InvoiceLine
    {
        return $this->invoiceLine;
    }

}