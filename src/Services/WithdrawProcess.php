<?php

declare(strict_types=1);

namespace Payment\Commission\Services;

use Payment\Commission\Interfaces\ICommission;

class WithdrawProcess 
{
    public function process(ICommission $commission)
    {
        return $commission->getCommissionAmount();
    }
}
