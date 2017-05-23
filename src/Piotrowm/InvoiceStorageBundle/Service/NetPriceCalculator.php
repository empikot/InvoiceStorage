<?php

namespace Piotrowm\InvoiceStorageBundle\Service;

use Piotrowm\InvoiceStorageBundle\Exception\GrossPriceCannotBeNegative;
use Piotrowm\InvoiceStorageBundle\Exception\TaxValueMustBeReasonable;

class NetPriceCalculator
{
    /**
     * calculates net price
     * @param float $grossPrice
     * @param int $tax
     * @return float
     * @throws GrossPriceCannotBeNegative
     * @throws TaxValueMustBeReasonable
     */
    public function calculateNetPrice(float $grossPrice, int $tax) : float
    {
        if ($grossPrice < 0) {
            throw new GrossPriceCannotBeNegative("given gross price: ".$grossPrice);
        }
        if ($tax < 0 || $tax >= 100) {
            throw new TaxValueMustBeReasonable("given tax value: ".$tax);
        }
        return round(100 * $grossPrice / (100 + $tax), 2);
    }

}