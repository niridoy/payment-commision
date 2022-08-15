<?php

declare(strict_types=1);

namespace Payment\Commission\Interfaces;

interface IExchangeRate 
{
    public function getExchangeAmount($from_currency, $amount, $to_currency);

    public function getRate($currency);
}
