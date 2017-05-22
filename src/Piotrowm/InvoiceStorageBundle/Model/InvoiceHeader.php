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

}