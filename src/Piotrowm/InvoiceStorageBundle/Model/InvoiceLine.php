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
    
}