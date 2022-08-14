<?php

declare(strict_types=1);

namespace Payment\Commission\Interfaces;

interface ICommission
{
    public function getCommissionAmount();
}
