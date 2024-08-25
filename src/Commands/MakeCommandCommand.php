<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class MakeCommandCommand extends Command
{
    protected $signature = 'make:command_extended {model_name}
        {--sub_folders=0}
    ';

    protected $description = 'command for creating repository';

    public function __construct(
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(ConsoleOutput $output): int
    {
        try {
            $modelName = $this->argument('model_name');
            $subFolders = $this->option('sub_folders');

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
