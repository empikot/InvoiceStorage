<?php

namespace Piotrowm\InvoiceStorageBundle\Service;

use Piotrowm\InvoiceStorageBundle\Exception\ShipmentDoesntExist;

class ShipmentLoader
{
    /**
     * mocked shipment methods dictionary
     * @var array
     */
    private $shipments = array(
        'SM_INPOST' => 1001,
        'SM_DHL'    => 1002,
        'SM_POST'   => 1003,
    );

    /**
     * returns product id for given shipment method symbol
     * @param string $symbol
     * @return int
     * @throws ShipmentDoesntExist
     */
    public function getShipmentIdBySymbol(string $symbol) : int
    {
        if (isset($this->shipments[$symbol])) {
            return $this->shipments[$symbol];
        }
        throw new ShipmentDoesntExist("input symbol ".$symbol);
    }
}
