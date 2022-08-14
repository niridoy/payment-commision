<?php

declare(strict_types=1);

namespace Payment\Commission\Services;

use Payment\Commission\Interfaces\ITranaction;

class Excel implements ITranaction
{
    protected $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function getTranactions() : array
    {
        $csv_file = file($this->url);
        $data = [];
        foreach ($csv_file as $line) {
            $data[] = str_getcsv($line);
        }
        return $data;
    }
}
