<?php

namespace Piotrowm\InvoiceStorageBundle\Model;

class CustomerInvoiceData
{
    private $id;
    private $name;
    private $taxIdentifier;

    public function __construct(int $id, string $name, string $taxIdentifier)
    {
        $this->id = $id;
        $this->name = $name;
        $this->taxIdentifier = $taxIdentifier;
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getTaxIdentifier() : string
    {
        return $this->taxIdentifier;
    }

}