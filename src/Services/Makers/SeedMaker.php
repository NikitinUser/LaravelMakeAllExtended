<?php

namespace Nikitinuser\LaravelMakeAllExtended\Services\Makers;

use Nikitinuser\LaravelMakeAllExtended\Dto\TemplateDto;
use Nikitinuser\LaravelMakeAllExtended\Services\Makers\BaseMaker;

class SeedMaker extends BaseMaker
{
    public const TEMPLATE_FILE = '/Seeder.txt';
    public const POSTFIX = 'Seeder';
    public const NAMESPACE_BASE = 'Database\Seeders';
    public const RELATIVE_PATH_BASE = '/../database/seeders/';

    /**
     * @param string $subFolders
     *
     * @return TemplateDto
     */
    public function make(string $subFolders = ''): TemplateDto
    {
        $template = $this->getTemplate(self::TEMPLATE_FILE);
        $dto = $this->getDto(
            $this->modelTemplateDto->class,
            self::POSTFIX,
            self::NAMESPACE_BASE,
            self::RELATIVE_PATH_BASE,
            $subFolders
        );

        $dto->content = sprintf(
            $template,
            $dto->class,
            '// Todo'
        );

        return $dto;
    }
}
