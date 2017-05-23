<?php

namespace Piotrowm\InvoiceStorageBundle\Service;

use Piotrowm\InvoiceStorageBundle\Exception\CustomerAddressDoesntExist;
use Piotrowm\InvoiceStorageBundle\Exception\CustomerInvoiceDataDoesntExist;
use Piotrowm\InvoiceStorageBundle\Model\CustomerAddress;
use Piotrowm\InvoiceStorageBundle\Model\CustomerInvoiceData;

class CustomerDataLoader
{
    /**
     * mocked customer address
     * @var array
     */
    private $address = array(
        1 => array(
            'name'      => 'Klient Testowy',
            'street'    => 'ul. Testowa 3/17',
            'zipCode'   => '03-113',
            'city'      => 'Pruszcz Gdański'
        ),
    );

    private $invoiceData = array(
        1 => array(
            'name'  => '',
            'taxIdentifier' => '1681118256'
        ),
    );

    /**
     * returns customer address by id
     * @param int $id
     * @return CustomerAddress
     * @throws CustomerAddressDoesntExist
     */
    public function findAddressById(int $id) : CustomerAddress
    {
        if (isset($this->address[$id])) {
            $addressData = $this->address[$id];
            return new CustomerAddress($id, $addressData['name'], $addressData['street'], $addressData['zipCode'], $addressData['city']);
        }
        throw new CustomerAddressDoesntExist("send customer address id ".$id);
    }

    /**
     * return customer invoice data by id
     * @param int $id
     * @return CustomerInvoiceData
     * @throws CustomerInvoiceDataDoesntExist
     */
    public function findInvoiceDataById(int $id)
    {
        if (isset($this->invoiceData[$id])) {
            $invoiceData = $this->invoiceData[$id];
            return new CustomerInvoiceData($id, $invoiceData['name'], $invoiceData['taxIdentifier']);
        }
        throw new CustomerInvoiceDataDoesntExist("send invoice data id ".$id);
    }

}