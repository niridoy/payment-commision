<?php

declare(strict_types=1);

namespace Payment\Commission\Services;

use Payment\Commission\Interfaces\ICommission;

class Deposit implements ICommission
{
    protected $amount;
    protected $currency;
    protected $deposit_rate = 0.03;

    public function __construct($tranaction)
    {
        $this->amount = $tranaction[4];
        $this->currency = $tranaction[5];
    }

    public function getCommissionAmount()
    {
        if($this->currency != 'EUR') {
            $exchange_rate = ExchangeRate::getInstance();
            $amount_after_conversion = $exchange_rate->getExchangeAmount($this->currency, $this->amount);
            $this->amount = ($amount_after_conversion / 100) * $this->deposit_rate;
        }
        $commision = ($this->amount / 100) * $this->deposit_rate;
        return round($commision, 2, PHP_ROUND_HALF_UP);
    }
}
