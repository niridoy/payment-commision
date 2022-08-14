<?php

declare(strict_types=1);

namespace Payment\Commission\Services;

class CommisionProcess
{
    private $tranactions;
    private $last_tranactions = [];
    
    public function __construct($tranactions)
    {
        $this->tranactions = $tranactions;
    }

    public function process() : array
    {
        $commissions = [];
        foreach($this->tranactions as $tranaction) {
            if( $tranaction[3] == 'deposit') {
                $deposit = new Deposit($tranaction);
                $commissions[] = $deposit->getCommissionAmount();
            } else { 
                $withdraw = new WithdrawProcess();
                if ($tranaction[2] == 'business') {
                    $commissions[] = $withdraw->process(new BusinessWithdraw($tranaction));
                } else { 
                    $commissions[] = $withdraw->process(new PrivateWithdraw($tranaction, $this->last_tranactions));
                }
                $this->last_tranactions[] = $tranaction;
            }
        }
        return $commissions;
    }
}
