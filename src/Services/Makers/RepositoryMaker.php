<?php

namespace Nikitinuser\LaravelMakeAllExtended\Services\Makers;

use Nikitinuser\LaravelMakeAllExtended\Dto\TemplateDto;
use Nikitinuser\LaravelMakeAllExtended\Services\Makers\BaseMaker;

class RepositoryMaker extends BaseMaker
{
    public const TEMPLATE_FILE = '/Repository.txt';
    public const POSTFIX = 'Repository';
    public const NAMESPACE_BASE = 'App\Repositories';
    public const RELATIVE_PATH_BASE = '/Repositories/';

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
            $dto->namespace,
            $this->modelTemplateDto->namespace . '\\' . $this->modelTemplateDto->class,
            $dto->class,
            $this->modelTemplateDto->class
        );

        return $dto;
    }
}
