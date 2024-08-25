<?php

namespace Nikitinuser\LaravelMakeAllExtended\Services\Makers;

use Nikitinuser\LaravelMakeAllExtended\Dto\TemplateDto;

trait TransformerTrait
{
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
            $dto->class,
        );

        return $dto;
    }
}
