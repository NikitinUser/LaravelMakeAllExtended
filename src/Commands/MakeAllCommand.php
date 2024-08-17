<?php

namespace Nikitinuser\LaravelMakeAllExtended\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;


class MakeAllCommand extends Command
{
    protected $signature = 'make:all_extended';

    protected $description = 'command for creating:
        model, seed, factory, repository, service, controller, formrequest,
        api, dto, request/response transformes based on migration';

    /**
     * Execute the console command.
     */
    public function handle(ConsoleOutput $output): int
    {
        try {
            $progressBar = new ProgressBar($output);
            $progressBar->start();
            $progressBar->setFormat('debug');

            $progressBar->advance();

            $progressBar->finish();
        } catch (\Throwable $t) {
            dump($t->getMessage());
            throw $t;
        }

        echo "\n";
        return 0;
    }
}
