<?php

namespace Nikitinuser\LaravelMakeAllExtended\Commands;

use Illuminate\Console\Command;
use Nikitinuser\LaravelMakeAllExtended\Services\MakeModel;
use Nikitinuser\LaravelMakeAllExtended\Services\Parser;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class MakeAllCommand extends Command
{
    protected $signature = 'make:all_extended
        {model_name}
        {--migration_filename=0}
        {--migration_path=0}
        {--sub_folders=0}
        {--controller_mode=api}
        {--route=api}
    ';

    protected $description = 'command for creating:
        model, seed, factory, repository, service, controller, formrequest,
        api, dto, request/response transformes based on migration';

    public function __construct(
        private MakeModel $makeModel,
        private Parser $parser,
    ) {
    }

    /**
     * Execute the console command.
     */
    public function handle(ConsoleOutput $output): int
    {
        try {
            $modelName = $this->argument('model_name');
            $migrationFilename = $this->option('migration_filename');
            $migrationPath = $this->option('migration_path');
            $subFolders = $this->option('sub_folders');
            $controllerMode = $this->option('controller_mode');
            $route = $this->option('route');

            $progressBar = new ProgressBar($output);
            $progressBar->start();
            $progressBar->setFormat('debug');

            $columns = ($this->parser)($migrationFilename);
            $progressBar->advance();

            ($this->makeModel)($modelName, $columns, $subFolders);

            $progressBar->finish();
        } catch (\Throwable $t) {
            dump($t->getMessage());
            throw $t;
        }

        echo "\n";
        return 0;
    }
}
