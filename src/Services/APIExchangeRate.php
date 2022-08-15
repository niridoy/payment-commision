<?php

declare(strict_types=1);

namespace Payment\Commission\Services;

use Payment\Commission\Interfaces\IExchangeRate;

class APIExchangeRate implements IExchangeRate
{
    protected $url = "https://developers.paysera.com/tasks/api/currency-exchange-rates";
    protected $rates;

    public function __construct()
    {
        $this->setCurrencyExchangeRates();
    }

    public function getExchangeAmount($from, $amount, $to = "EUR")
    {
        return round($amount / ($this->rates["rates"][$from] / $this->rates["rates"][$to]), 2);
    }

    public function getRate($currency)
    {
        return $this->rates["rates"][$currency];
    }

    private function setCurrencyExchangeRates()
    {
        $result = file_get_contents($this->url);
        $this->rates = json_decode($result, true);
    }
}
