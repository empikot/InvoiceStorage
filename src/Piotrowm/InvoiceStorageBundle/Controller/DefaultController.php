<?php

namespace Piotrowm\InvoiceStorageBundle\Controller;

use Piotrowm\InvoiceStorageBundle\Service\InvoiceBuilder;
use Piotrowm\InvoiceStorageBundle\Service\InvoiceStorage;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        /**
         *
         *
         * `id, status, customer_address_id, customer_invoice_data_id, shipment_type, shipment_price, payment_type, items_price`
         *Zamówione produkty (1 linia per produkt):*
        `id, order_id, product_id, gross_price, tax_percent`
         *
         *
         */



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
        //var_dump($this->container->get('piotrowm_invoice_storage.customerDataLoader')); die('aaa');
        $builder = new InvoiceBuilder(
            $this->container, $this->getDoctrine()->getManager()
        );
        $invoiceObj = $builder->setOrderData($inputData)
            ->build()
            ->getInvoice();
        var_dump($invoiceObj); die('<br><br>fin.');
        $storage = new InvoiceStorage($this->getDoctrine()->getManager(), $invoiceObj);
        $storage->store();
        return $this->render('PiotrowmInvoiceStorageBundle:Default:index.html.twig');
    }
}
