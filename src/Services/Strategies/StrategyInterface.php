<?php

namespace Nikitinuser\LaravelMakeAllExtended\Services\Strategies;

use Nikitinuser\LaravelMakeAllExtended\Dto\TemplateDto;

interface StrategyInterface
{
    public function make(string $subFolders = ''): TemplateDto;
}
