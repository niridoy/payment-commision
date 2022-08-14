<?php

declare(strict_types=1);

namespace Payment\Commission\Abstracts;

use Payment\Commission\Services\ExchangeRate;

abstract class Withdraw 
{
    protected $date;
    protected $identificator;
    protected $type;
    protected $amount;
    protected $currency;
    protected $exchange_rate;

    public function __construct($tranaction)
    {
        $this->date = $tranaction[0];
        $this->identificator = $tranaction[1];
        $this->type = $tranaction[2];
        $this->amount = $tranaction[4];
        $this->currency = $tranaction[5];
        $this->exchange_rate = ExchangeRate::getInstance();
        $this->setAmount();
    }

    protected function setAmount()
    {
        $this->amount = $this->exchange_rate->getExchangeAmount($this->currency, $this->amount);
    }
}
