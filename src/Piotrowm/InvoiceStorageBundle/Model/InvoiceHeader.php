<?php

namespace Piotrowm\InvoiceStorageBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="invoice")
 */
class InvoiceHeader
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="order_id", type="integer")
     */
    private $orderId;

    /**
     * @ORM\Column(name="invoice_number", type="string", length=30, unique=true)
     */
    private $invoiceNumber;

    /**
     * @ORM\Column(name="price_sum_net", type="decimal", scale=2)
     */
    private $netPriceSum;

    /**
     * @ORM\Column(name="price_sum_gross", type="decimal", scale=2)
     */
    private $grossPriceSum;

    /**
     * @ORM\Column(name="payment_type", type="string", length=10)
     */
    private $paymentType;

    /**
     * @ORM\Column(name="customer_name", type="string", length=100)
     */
    private $customerName;

    /**
     * @ORM\Column(name="customer_street", type="string", length=60)
     */
    private $customerStreet;

    /**
     * @ORM\Column(name="customer_zip_code", type="string", length=7)
     */
    private $customerZipCode;

    /**
     * @ORM\Column(name="customer_city", type="string", length=60)
     */
    private $customerCity;

    /**
     * @ORM\Column(name="customer_tax_identifier", type="string", length=10)
     */
    private $customerTaxIdentifier;

    /**
     * @ORM\OneToMany(targetEntity="InvoiceLine", mappedBy="invoiceId")
     */
    private $invoiceLines;

    public function __construct()
    {
        $this->invoiceLines = new ArrayCollection();
    }


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
     * Set orderId
     *
     * @param integer $orderId
     *
     * @return InvoiceHeader
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * Get orderId
     *
     * @return integer
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * Set invoiceNumber
     *
     * @param string $invoiceNumber
     *
     * @return InvoiceHeader
     */
    public function setInvoiceNumber($invoiceNumber)
    {
        $this->invoiceNumber = $invoiceNumber;

        return $this;
    }

    /**
     * Get invoiceNumber
     *
     * @return string
     */
    public function getInvoiceNumber()
    {
        return $this->invoiceNumber;
    }

    /**
     * Get netPriceSum
     *
     * @return string
     */
    public function getNetPriceSum()
    {
        return $this->netPriceSum;
    }

    /**
     * Set grossPriceSum
     *
     * @param string $grossPriceSum
     *
     * @return InvoiceHeader
     */
    public function setGrossPriceSum($grossPriceSum)
    {
        $this->grossPriceSum = $grossPriceSum;

        return $this;
    }

    /**
     * Get grossPriceSum
     *
     * @return string
     */
    public function getGrossPriceSum()
    {
        return $this->grossPriceSum;
    }

    /**
     * Set paymentType
     *
     * @param string $paymentType
     *
     * @return InvoiceHeader
     */
    public function setPaymentType($paymentType)
    {
        $this->paymentType = $paymentType;

        return $this;
    }

    /**
     * Get paymentType
     *
     * @return string
     */
    public function getPaymentType()
    {
        return $this->paymentType;
    }

    /**
     * Set customerName
     *
     * @param string $customerName
     *
     * @return InvoiceHeader
     */
    public function setCustomerName($customerName)
    {
        $this->customerName = $customerName;

        return $this;
    }

    /**
     * Get customerName
     *
     * @return string
     */
    public function getCustomerName()
    {
        return $this->customerName;
    }

    /**
     * Set customerStreet
     *
     * @param string $customerStreet
     *
     * @return InvoiceHeader
     */
    public function setCustomerStreet($customerStreet)
    {
        $this->customerStreet = $customerStreet;

        return $this;
    }

    /**
     * Get customerStreet
     *
     * @return string
     */
    public function getCustomerStreet()
    {
        return $this->customerStreet;
    }

    /**
     * Set customerZipCode
     *
     * @param string $customerZipCode
     *
     * @return InvoiceHeader
     */
    public function setCustomerZipCode($customerZipCode)
    {
        $this->customerZipCode = $customerZipCode;

        return $this;
    }

    /**
     * Get customerZipCode
     *
     * @return string
     */
    public function getCustomerZipCode()
    {
        return $this->customerZipCode;
    }

    /**
     * Set customerCity
     *
     * @param string $customerCity
     *
     * @return InvoiceHeader
     */
    public function setCustomerCity($customerCity)
    {
        $this->customerCity = $customerCity;

        return $this;
    }

    /**
     * Get customerCity
     *
     * @return string
     */
    public function getCustomerCity()
    {
        return $this->customerCity;
    }

    /**
     * Set customerTaxIdentifier
     *
     * @param string $customerTaxIdentifier
     *
     * @return InvoiceHeader
     */
    public function setCustomerTaxIdentifier($customerTaxIdentifier)
    {
        $this->customerTaxIdentifier = $customerTaxIdentifier;

        return $this;
    }

    /**
     * Get customerTaxIdentifier
     *
     * @return string
     */
    public function getCustomerTaxIdentifier()
    {
        return $this->customerTaxIdentifier;
    }

    /**
     * Add invoiceLine
     *
     * @param \Piotrowm\InvoiceStorageBundle\Model\InvoiceLine $invoiceLine
     *
     * @return InvoiceHeader
     */
    public function addInvoiceLine(\Piotrowm\InvoiceStorageBundle\Model\InvoiceLine $invoiceLine)
    {
        $this->invoiceLines[] = $invoiceLine;
        $this->netPriceSum += $invoiceLine->getNetPrice();

        return $this;
    }

    /**
     * Remove invoiceLine
     *
     * @param \Piotrowm\InvoiceStorageBundle\Model\InvoiceLine $invoiceLine
     */
    public function removeInvoiceLine(\Piotrowm\InvoiceStorageBundle\Model\InvoiceLine $invoiceLine)
    {
        if ($this->invoiceLines->contains($invoiceLine)) {
            $this->invoiceLines->removeElement($invoiceLine);
            $this->netPriceSum -= $invoiceLine->getNetPrice();
        }
    }

    /**
     * Get invoiceLines
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInvoiceLines()
    {
        return $this->invoiceLines;
    }
}
