<?php

namespace Nikitinuser\LaravelMakeAllExtended\Services\Makers;

use Nikitinuser\LaravelMakeAllExtended\Dto\TemplateDto;
use Nikitinuser\LaravelMakeAllExtended\Services\Makers\BaseMaker;

class DtoMaker extends BaseMaker
{
    public const TEMPLATE_FILE = '/Dto.txt';
    public const POSTFIX = 'Dto';
    public const NAMESPACE_BASE = 'App\Dto';
    public const RELATIVE_PATH_BASE = '/Dto/';

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
            $dto->namespace,
            $dto->class,
            $this->getAttributes($this->modelTemplateDto->modelColumns)
        );

        return $dto;
    }

    /**
     * @param array $modelColumns
     *
     * @return string
     */
    private function getAttributes(array $modelColumns): string
    {
        $attributes = '';

        foreach ($modelColumns as $name => $properties) {
            $attributes .= 'public ?' . $properties['type_php'] . ' ' . $name . ' = null;\n\t\t\t';
        }

        return $attributes;
    }
}
