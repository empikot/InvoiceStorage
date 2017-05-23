<?php

namespace Piotrowm\InvoiceStorageBundle\Model;

class CustomerAddress
{
    private $id;
    private $name;
    private $street;
    private $zipCode;
    private $city;

    public function __construct(int $id, string $name, string $street, string $zipCode, string $city)
    {
        $this->id = $id;
        $this->name = $name;
        $this->street = $street;
        $this->zipCode = $zipCode;
        $this->city = $city;
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getStreet() : string
    {
        return $this->street;
    }

    public function getZipCode() : string
    {
        return $this->zipCode;
    }

    public function getCity() : string
    {
        return $this->city;
    }


}