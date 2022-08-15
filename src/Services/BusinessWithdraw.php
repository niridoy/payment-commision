<?php

declare(strict_types=1);

namespace Payment\Commission\Services;

use Payment\Commission\Abstracts\Withdraw;
use Payment\Commission\Interfaces\ICommission;

class BusinessWithdraw extends Withdraw implements ICommission
{
    protected $withdraw_rate_for_bussiness_user = 0.5;
    
    public function __construct($tranaction)
    {
        parent::__construct($tranaction);
    }

    public function getCommissionAmount()
    {
        $commision = ($this->amount / 100) * $this->withdraw_rate_for_bussiness_user;
        return round(round($commision, 1, PHP_ROUND_HALF_UP), 2);
    }
}
