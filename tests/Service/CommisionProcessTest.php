<?php

declare(strict_types=1);

namespace Payment\Commission\Tests\Service;

use Payment\Commission\Services\CommisionProcess;
use PHPUnit\Framework\TestCase;
use Payment\Commission\Services\Excel;

class CommisionProcessTest extends TestCase
{
    private $commission_process;

    public function setUp()
    {
        $excel = new Excel('input.csv');
        $this->commission_process = new CommisionProcess($excel->getTranactions());
    }

    public function testAdd()
    {
        $this->assertEquals(
           [ 0.6, 3, 0, 0.06, 1.5, 0, 0.7, 0.3, 0.3, 3, 0, 0, 8607.4],
            $this->commission_process->process()
        );
    }
}
