<?php

namespace Nikitinuser\LaravelMakeAllExtended\Services\Strategies;

use Nikitinuser\LaravelMakeAllExtended\Dto\TemplateDto;
use Nikitinuser\LaravelMakeAllExtended\Services\Strategies\StrategyInterface;

abstract class BaseStrategy implements StrategyInterface
{
    public const TEMPLATES_FOLDER = '/../templates';

    protected TemplateDto $modelTemplateDto;

    abstract public function make(string $subFolders = ''): TemplateDto;

    /**
     * @param TemplateDto $modelTemplateDto
     *
     * @return self
     */
    public function setModelTemplateDto(TemplateDto $modelTemplateDto): self
    {
        $this->modelTemplateDto = $modelTemplateDto;
        return $this;
    }

    protected function getTemplate(string $template): string
    {
        $path = __DIR__ . self::TEMPLATES_FOLDER . $template;
        return file_get_contents($path);
    }

    protected function getDto(
        string $name,
        string $postfix,
        string $namespace,
        string $path,
        string $subFolders
    ): TemplateDto {
        $dto = new TemplateDto();

        $dto->class = $name . $postfix;
        $dto->namespace = $namespace . $subFolders;
        $dto->relativePath = $path . $subFolders;

        return $dto;
    }

    protected function getConstructorClassAttribute(string $class, string $mode = 'private'): string
    {
        return $mode . ' ' . $class . ' ' . lcfirst($class);
    }
}
