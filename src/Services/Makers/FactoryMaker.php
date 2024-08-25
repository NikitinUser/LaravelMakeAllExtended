<?php

namespace Nikitinuser\LaravelMakeAllExtended\Services\Makers;

use Nikitinuser\LaravelMakeAllExtended\Dto\TemplateDto;
use Nikitinuser\LaravelMakeAllExtended\Services\Makers\BaseMaker;

class FactoryMaker extends BaseMaker
{
    public const TEMPLATE_FILE = '/Factory.txt';
    public const POSTFIX = 'Factory';
    public const NAMESPACE_BASE = 'Database\Factories';
    public const RELATIVE_PATH_BASE = '/../database/factories/';

    /**
     * @param string|null $subFolders
     *
     * @return TemplateDto
     */
    public function make(?string $subFolders = ''): TemplateDto
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
            $this->modelTemplateDto->namespace . '\\' . $this->modelTemplateDto->class,
            $dto->class,
            '// Todo'
        );

        return $dto;
    }
}
