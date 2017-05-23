<?php

namespace Piotrowm\InvoiceStorageBundle\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Piotrowm\InvoiceStorageBundle\Model\InvoiceHeader;

class InvoiceStorage
{

    private $entityManager;
    private $invoice;

    /**
     * InvoiceStorage constructor.
     * @param ObjectManager $entityManager
     * @param InvoiceHeader $invoice
     */
    public function __construct(ObjectManager $entityManager, InvoiceHeader $invoice)
    {
        $this->entityManager = $entityManager;
        $this->invoice = $invoice;
    }
    
    public function store()
    {
        $this->storeInvoiceHeader();
        $this->storeInvoiceLines();
        $this->entityManager->flush();
    }

    private function storeInvoiceHeader()
    {
        $this->entityManager->persist($this->invoice);
    }

    private function storeInvoiceLines()
    {
        foreach ($this->invoice->getInvoiceLines() as $invoiceLine) {
            $this->entityManager->persist($invoiceLine);
        }
    }
}