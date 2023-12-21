<?php

namespace App\Helpers;

use App\Helpers\Concerns\ImportReporter;
use Illuminate\Console\Command;
use Symfony\Component\Console\Helper\ProgressBar;

final class ConsoleImportReporter implements ImportReporter
{
    protected $bar;

    public function __construct(
        protected Command $command
    ) {
    }

    public function setCount(int $count)
    {

        ProgressBar::setFormatDefinition('custom', " %current%/%max% -- %message%\n [%bar%]\n ");

        $this->bar = $this->command
            ->getOutput()
            ->createProgressBar($count);

        $this->bar->setFormat('custom');
    }

    public function increment(string $message)
    {
        $this->bar->setMessage($message);
        $this->bar->advance();
    }

    public function report(string $message)
    {
        $this->command->info($message);
    }

    public function done(string $message)
    {
        $this->command->comment($message);
    }
}
