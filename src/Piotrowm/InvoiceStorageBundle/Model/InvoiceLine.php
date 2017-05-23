<?php

namespace Piotrowm\InvoiceStorageBundle\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="invoice_line")
 */
class InvoiceLine
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="InvoiceHeader", inversedBy="invoiceLines")
     * @ORM\JoinColumn(name="invoice_id", referencedColumnName="id")
     */
    private $invoiceId;

    /**
     * @ORM\Column(name="product_id", type="integer")
     */
    private $productId;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(name="price_net_item", type="decimal", scale=2)
     */
    private $netPriceItem;

    /**
     * @ORM\Column(name="price_gross_item", type="decimal", scale=2)
     */
    private $grossPriceItem;

    /**
     * @ORM\Column(name="price_net", type="decimal", scale=2)
     */
    private $netPrice;

    /**
     * @ORM\Column(name="price_gross", type="decimal", scale=2)
     */
    private $grossPrice;

    /**
     * @ORM\Column(name="tax_percent", type="integer")
     */
    private $taxPercent;
    

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set productId
     *
     * @param integer $productId
     *
     * @return InvoiceLine
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;

        return $this;
    }

    /**
     * Get productId
     *
     * @return integer
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return InvoiceLine
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set netPriceItem
     *
     * @param string $netPriceItem
     *
     * @return InvoiceLine
     */
    public function setNetPriceItem($netPriceItem)
    {
        $this->netPriceItem = $netPriceItem;

        return $this;
    }

    /**
     * Get netPriceItem
     *
     * @return string
     */
    public function getNetPriceItem()
    {
        return $this->netPriceItem;
    }

    /**
     * Set grossPriceItem
     *
     * @param string $grossPriceItem
     *
     * @return InvoiceLine
     */
    public function setGrossPriceItem($grossPriceItem)
    {
        $this->grossPriceItem = $grossPriceItem;

        return $this;
    }

    /**
     * Get grossPriceItem
     *
     * @return string
     */
    public function getGrossPriceItem()
    {
        return $this->grossPriceItem;
    }

    /**
     * Set netPrice
     *
     * @param string $netPrice
     *
     * @return InvoiceLine
     */
    public function setNetPrice($netPrice)
    {
        $this->netPrice = $netPrice;

        return $this;
    }

    /**
     * Get netPrice
     *
     * @return string
     */
    public function getNetPrice()
    {
        return $this->netPrice;
    }

    /**
     * Set grossPrice
     *
     * @param string $grossPrice
     *
     * @return InvoiceLine
     */
    public function setGrossPrice($grossPrice)
    {
        $this->grossPrice = $grossPrice;

        return $this;
    }

    /**
     * Get grossPrice
     *
     * @return string
     */
    public function getGrossPrice()
    {
        return $this->grossPrice;
    }

    /**
     * Set taxPercent
     *
     * @param integer $taxPercent
     *
     * @return InvoiceLine
     */
    public function setTaxPercent($taxPercent)
    {
        $this->taxPercent = $taxPercent;

        return $this;
    }

    /**
     * Get taxPercent
     *
     * @return integer
     */
    public function getTaxPercent()
    {
        return $this->taxPercent;
    }

    /**
     * Set invoiceId
     *
     * @param \Piotrowm\InvoiceStorageBundle\Model\InvoiceHeader $invoice
     *
     * @return InvoiceLine
     */
    public function setInvoiceId(\Piotrowm\InvoiceStorageBundle\Model\InvoiceHeader $invoice = null)
    {
        $this->invoiceId = $invoice;

        return $this;
    }

    /**
     * Get invoiceId
     *
     * @return \Piotrowm\InvoiceStorageBundle\Model\InvoiceHeader
     */
    public function getInvoiceId()
    {
        return $this->invoiceId;
    }
}
