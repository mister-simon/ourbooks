<?php

namespace App\Helpers\Concerns;

interface ImportReporter
{
    public function setCount(int $count);

    public function increment(string $message);

    public function report(string $message);

    public function done(string $message);
}
