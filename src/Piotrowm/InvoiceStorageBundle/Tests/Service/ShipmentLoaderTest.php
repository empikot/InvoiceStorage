<?php
namespace Piotrowm\InvoiceStorageBundle\Tests\Service;

use PHPUnit\Framework\TestCase;
use Piotrowm\InvoiceStorageBundle\Service\ShipmentLoader;

class ShipmentLoaderTest extends TestCase
{
    public function testShipmentExists()
    {
        $loader = new ShipmentLoader();
        $shipmentId = $loader->getShipmentIdBySymbol('SM_INPOST');
        $this->assertNotEmpty($shipmentId);
    }

    public function testShipmentDoesntExist()
    {
        $loader = new ShipmentLoader();

        $this->expectException("Piotrowm\InvoiceStorageBundle\Exception\ShipmentDoesntExist");
        $loader->getShipmentIdBySymbol('SM_NOTEXISTINGONE');
    }
}