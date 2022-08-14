<?php

declare(strict_types=1);

namespace Payment\Commission\Interfaces;

interface IExchangeRate
{
    public function getExchangeAmount($currency,$amount);
}
