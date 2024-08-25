<?php

namespace Nikitinuser\LaravelMakeAllExtended\Services\Makers;

use Nikitinuser\LaravelMakeAllExtended\Dto\TemplateDto;
use Nikitinuser\LaravelMakeAllExtended\Services\Makers\MakerInterface;

abstract class BaseMaker implements MakerInterface
{
    public const TEMPLATES_FOLDER = '/../../templates';

    protected TemplateDto $modelTemplateDto;

    /**
     * @param string $subFolders
     *
     * @return TemplateDto
     */
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

    /**
     * @param string $template
     *
     * @return string
     */
    protected function getTemplate(string $template): string
    {
        $path = __DIR__ . self::TEMPLATES_FOLDER . $template;
        return file_get_contents($path);
    }

    /**
     * @param string $name
     * @param string $postfix
     * @param string $namespace
     * @param string $path
     * @param string $subFolders
     *
     * @return TemplateDto
     */
    protected function getDto(
        string $name,
        string $postfix,
        string $namespace,
        string $path,
        string $subFolders
    ): TemplateDto {
        $dto = new TemplateDto();

        $dto->class = $name . $postfix;
        $dto->namespace = $namespace . '\\' . $subFolders;
        $dto->relativePath = $path . $subFolders;

        return $dto;
    }

    /**
     * @param string $class
     * @param string $mode
     *
     * @return string
     */
    protected function getConstructorClassAttribute(string $class, string $mode = 'private'): string
    {
        return $mode . ' ' . $class . ' $' . lcfirst($class);
    }

    /**
     * @param string $class
     *
     * @return string
     */
    protected function getClassMethodAsParam(string $class): string
    {
        return $class . ' ' . lcfirst($class);
    }
}
