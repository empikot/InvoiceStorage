<?php

namespace Piotrowm\InvoiceStorageBundle\Service;

class NetPriceCalculator
{

    public function calculateNetPrice(float $grossPrice, int $tax) : float
    {
        // sprawdzanie ceny i podatku?
        // dodac formatowanie liczby na decimal .2?
        return round(100 * $grossPrice / (100 + $tax), 2);
    }

}