<?php

namespace Piotrowm\InvoiceStorageBundle\Service;

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
     */
    public function getShipmentIdBySymbol(string $symbol) : int
    {
        if (isset($this->shipments[$symbol])) {
            return $this->shipments[$symbol];
        }
    }
}
