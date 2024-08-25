<?php

namespace Nikitinuser\LaravelMakeAllExtended\Services\Makers;

use Nikitinuser\LaravelMakeAllExtended\Dto\TemplateDto;
use Nikitinuser\LaravelMakeAllExtended\Services\Makers\BaseMaker;

class ServiceMaker extends BaseMaker
{
    public const TEMPLATE_FILE = '/Service.txt';
    public const POSTFIX = 'Service';
    public const NAMESPACE_BASE = 'App\Services';
    public const RELATIVE_PATH_BASE = '/Services/';

    private TemplateDto $repositoryTemplate;
    private TemplateDto $dtoTemplate;

    /**
     * @param TemplateDto $repositoryTemplate
     *
     * @return self
     */
    public function setRepositoryTempalte(TemplateDto $repositoryTemplate): self
    {
        $this->repositoryTemplate = $repositoryTemplate;
        return $this;
    }

    /**
     * @param TemplateDto $dtoTemplate
     *
     * @return self
     */
    public function setDtoTemplate(TemplateDto $dtoTemplate): self
    {
        $this->dtoTemplate = $dtoTemplate;
        return $this;
    }

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
            $this->dtoTemplate->namespace . '\\' . $this->dtoTemplate->class,
            $this->repositoryTemplate->namespace . '\\' . $this->repositoryTemplate->class,
            $dto->class,
            $this->getConstructorClassAttribute($this->repositoryTemplate->class)
        );

        return $dto;
    }
}
