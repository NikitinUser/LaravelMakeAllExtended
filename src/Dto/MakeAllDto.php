<?php

namespace Nikitinuser\LaravelMakeAllExtended\Dto;

class MakeAllDto
{
    public ?string $modelName = null;
    public ?string $migrationFilename = null;
    public ?string $migrationPath = null;
    public ?string $subFolders = null;
    public ?int $api = null;
    public ?int $invokable = null;
    public ?string $route = null;
}
