<?php

declare(strict_types=1);

namespace Payment\Commission\Services;

use Payment\Commission\Interfaces\ICommission;
use Payment\Commission\Abstracts\Withdraw;

class PrivateWithdraw extends Withdraw implements ICommission
{
    protected $last_tranactions;
    protected $withdraw_rate_for_private_user = 0.3;
    protected $withdraw_free_limit_amount = 1000;
    protected $weekly_withdraw_limit = 3;
    
    public function __construct($tranaction,$last_tranactions)
    {
        parent::__construct($tranaction);
        $this->last_tranactions = $last_tranactions;
    }

    public function getCommissionAmount()
    {
        $week_total_withdraww = $this->getWeekTotalWithdrawAmount(); 
        $commision = 0;
        if ($this->isWeeklyWithdrawLimitExceed())  {
            if ($week_total_withdraww >= $this->withdraw_free_limit_amount) {
                $commision = ( $this->amount / 100) * $this->withdraw_rate_for_private_user;
            } else {
                $chargeable_amount = ($this->amount + $week_total_withdraww) - $this->withdraw_free_limit_amount;
                if($chargeable_amount > 0 )
                {
                    $commision = ( $chargeable_amount / 100) * $this->withdraw_rate_for_private_user;
                }
            }
        } else {
            $commision = ( $this->amount / 100) * $this->withdraw_rate_for_private_user;
        }
        if($this->currency != 'EUR') {
            
            $commision = $this->exchange_rate->getExchangeAmount('EUR', $commision, $this->currency);
        }  
        return round($commision, 1, PHP_ROUND_HALF_UP);
    }

    protected function isWeeklyWithdrawLimitExceed()
    {
       return ($this->getCurrentWeekTransactions() > $this->weekly_withdraw_limit) ? true : false;
    }

    protected function getWeekTotalWithdrawAmount() 
    {
        $current_week_total_withdraw = 0;
        foreach($this->getCurrentWeekTransactions() as $last_tranaction) {
            if ($last_tranaction[5] != 'EUR'){
                $amount_after_conversion = $this->exchange_rate->getExchangeAmount($last_tranaction[5], $last_tranaction[4]);
                $current_week_total_withdraw += $amount_after_conversion;
            } else {
                $current_week_total_withdraw += $last_tranaction[4];
            }
        }
        return $current_week_total_withdraw;
    }

    protected function getCurrentWeekTransactions()
    {
        //Determine last sunday date
        $date = new \DateTime($this->date); 
        $current_date = $date->modify('last monday');
        $last_monday_date = strtotime($current_date->format('Y-m-d'));
        //Current date
        $current_tranaction_date = strtotime($this->date);
        $current_week_transtions = [];
        foreach($this->last_tranactions as $last_trans) {
            $last_tranaction_date = strtotime($last_trans[0]);
            if ($last_tranaction_date >= $last_monday_date
                    &&  $last_tranaction_date <= $current_tranaction_date
                    && $last_trans[1] == $this->identificator){
                $current_week_transtions[] = $last_trans;
            }
        }
        return $current_week_transtions;
    }

}
