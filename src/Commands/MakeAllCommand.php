<?php

namespace Nikitinuser\LaravelMakeAllExtended\Commands;

use Illuminate\Console\Command;
use Nikitinuser\LaravelMakeAllExtended\Dto\MakeAllDto;
use Nikitinuser\LaravelMakeAllExtended\Services\MakeAll;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class MakeAllCommand extends Command
{
    protected $signature = 'make:all_extended {model_name}
        {--migration_filename=0}
        {--migration_path=0}
        {--sub_folders=0}
        {--api=0}
        {--invokable=0}
    ';

    protected $description = 'command for creating:
        model, seed, factory, repository, service, controller, formrequest,
        dto, request/response transformes based on migration';

    public function __construct(
        private MakeAll $makeall
    ) {
        parent::__construct();
    }

    /**
     * @param ConsoleOutput $output
     *
     * @return int
     */
    public function handle(ConsoleOutput $output): int
    {
        try {
            $dto = $this->getInputDto();

            $progressBar = new ProgressBar($output);
            $progressBar->start();
            $progressBar->setFormat('debug');

            ($this->makeall)($dto);

            $progressBar->advance();
            $progressBar->finish();
        } catch (\Throwable $t) {
            dump($t->getMessage());
            throw $t;
        }

        echo "\n";
        return 0;
    }

    /**
     * @return MakeAllDto
     */
    private function getInputDto(): MakeAllDto
    {
        $dto = new MakeAllDto();

        $dto->modelName = $this->argument('model_name');
        $dto->migrationFilename = $this->option('migration_filename');
        $dto->migrationPath = $this->option('migration_path');
        $dto->subFolders = $this->option('sub_folders');
        $dto->api = $this->option('api');
        $dto->invokable = $this->option('invokable');

        return $dto;
    }
}
