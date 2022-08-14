<?php

require __DIR__ . '/vendor/autoload.php';

use Payment\Commission\Services\CommisionProcess;
use Payment\Commission\Services\Excel;

$excel = new Excel('input.csv');
$commission_process = new CommisionProcess($excel->getTranactions());

foreach($commission_process->process() as $commission) {
    print $commission . PHP_EOL;;
}

// print HOST;
