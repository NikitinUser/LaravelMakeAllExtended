<?php

namespace Nikitinuser\LaravelMakeAllExtended\Services;

use Nikitinuser\LaravelMakeAllExtended\Dto\MakeAllDto;
use Nikitinuser\LaravelMakeAllExtended\Services\Parser;
use Nikitinuser\LaravelMakeAllExtended\Services\FileMaker;

class MakeAll
{
    public function __construct(
        private FileMaker $fileMaker,
        private Parser $parser
    ) {
    }

    /**
     * @param MakeAllDto $dto
     *
     * @return void
     */
    public function handle(MakeAllDto $dto): void
    {
        $path = $this->getMigrationPath($dto->migrationFilename, $dto->migrationPath);
        $columns = $this->parser->parse($path);
        $this->fileMaker->make($dto, $columns);
    }

    /**
     * @param string $migrationFilename
     * @param string $migrationPath
     *
     * @return string
     */
    private function getMigrationPath(string $migrationFilename = '', string $migrationPath = ''): string
    {
        $path = config('make_all_extended.base_path');
        if (!empty($migrationPath)) {
            $path .= $migrationPath;
        } elseif (!empty($migrationFilename)) {
            $path .= config('make_all_extended.migrations_relative_path') . $migrationFilename;
        } else {
            throw new \Exception('fill migration_filename or migration_path options');
        }

        return $path;
    }
}
