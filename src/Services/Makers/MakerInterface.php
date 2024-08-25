<?php

namespace Nikitinuser\LaravelMakeAllExtended\Services\Makers;

use Nikitinuser\LaravelMakeAllExtended\Dto\TemplateDto;

interface MakerInterface
{
    /**
     * @param string $subFolders
     *
     * @return TemplateDto
     */
    public function make(string $subFolders = ''): TemplateDto;
}
