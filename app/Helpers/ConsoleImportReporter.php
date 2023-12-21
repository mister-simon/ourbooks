<?php

namespace App\Helpers;

use App\Helpers\Concerns\ImportReporter;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Symfony\Component\Console\Helper\ProgressBar;

final class ConsoleImportReporter implements ImportReporter
{
    protected ?ProgressBar $bar;

    public function __construct(
        protected Command $command
    ) {
    }

    public function setCount(int $count)
    {

        $this->bar = $this->command
            ->getOutput()
            ->createProgressBar($count);

        $this->bar->setBarWidth(53);
        $this->bar->setFormat(" %message%\n [%bar%]\n %current%/%max% %percent:3s%% %elapsed:16s%/%estimated:-16s% %memory:6s%\n");
    }

    public function increment(string $message)
    {
        $this->bar->setMessage(Str::limit($message, 50));
        $this->bar->advance();
    }

    public function report(string $message)
    {
        $this->command->info($message);
    }

    public function done(string $message)
    {
        $this->bar->finish();
        $this->command->comment($message);
    }
}
