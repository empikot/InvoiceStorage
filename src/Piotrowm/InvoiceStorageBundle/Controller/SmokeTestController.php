<?php

namespace Piotrowm\InvoiceStorageBundle\Controller;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Piotrowm\InvoiceStorageBundle\Exception\OrderDataIsIncomplete;
use Piotrowm\InvoiceStorageBundle\Service\InvoiceBuilder;
use Piotrowm\InvoiceStorageBundle\Service\InvoiceStorage;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SmokeTestController extends Controller
{

    /**
     * @Route("/saveInvoice")
     */
    public function saveInvoiceAction()
    {
        $inputData = json_decode(file_get_contents("php://input"), true);
        return $this->makeAndSaveInvoice($inputData);
    }

    /**
     * @Route("/smokeTest")
     */
    public function smokeTestAction()
    {
        $inputData = array(
            'id' => 1,
            'status' => 'zrealizowane',
            'customer_address_id' => 1,
            'customer_invoice_data_id' => 1,
            'shipment_type' => 'SM_INPOST',
            'shipment_price' => 12.00,
            'payment_type' => 'PM_PAYU',
            'items_price' => 177.00,
            'lines' => array(
                array(
                    'id' => 101,
                    'order_id' => 1,
                    'product_id' => 12345,
                    'quantity' => 1,
                    'gross_price' => 123.00,
                    'tax_percent' => 23
                ),
                array(
                    'id' => 102,
                    'order_id' => 1,
                    'product_id' => 2112,
                    'quantity' => 1,
                    'gross_price' => 54.00,
                    'tax_percent' => 8
                ),
            ),
        );
        return $this->makeAndSaveInvoice($inputData);
    }

    private function makeAndSaveInvoice($inputData)
    {
        try {
            $builder = new InvoiceBuilder(
                $this->container->get('piotrowm_invoice_storage.netPriceCalculator'),
                $this->container->get('piotrowm_invoice_storage.customerDataLoader'),
                $this->container->get('piotrowm_invoice_storage.shipmentLoader')
            );
            $invoiceObj = $builder->setOrderData($inputData)->build()->getInvoice();
        } catch (OrderDataIsIncomplete $ex) {
            die('[ERROR] order data is probably not valid: ' . $ex->getMessage());
        }
        try {
            $storage = new InvoiceStorage($this->getDoctrine()->getManager(), $invoiceObj);
            $storage->store();
        } catch (UniqueConstraintViolationException $ex) {
            die('[ERROR] invoice already exists for given order data: ' . $ex->getMessage());
        }
        return $this->render('PiotrowmInvoiceStorageBundle:Default:index.html.twig');
    }
}
