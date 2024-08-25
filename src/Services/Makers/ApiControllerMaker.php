<?php

namespace Nikitinuser\LaravelMakeAllExtended\Services\Makers;

use Nikitinuser\LaravelMakeAllExtended\Dto\TemplateDto;
use Nikitinuser\LaravelMakeAllExtended\Services\Makers\BaseController;

class ApiControllerMaker extends BaseController
{
    public const TEMPLATE_FILE = '/api_Controller.txt';

    private TemplateDto $createRequestTemplate;
    private TemplateDto $updateRequestTemplate;

    /**
     * @param TemplateDto $createRequestTemplate
     *
     * @return self
     */
    public function setCreateRequestTemplate(TemplateDto $createRequestTemplate): self
    {
        $this->createRequestTemplate = $createRequestTemplate;
        return $this;
    }

    /**
     * @param TemplateDto $updateRequestTemplate
     *
     * @return self
     */
    public function setUpdateRequestTemplate(TemplateDto $updateRequestTemplate): self
    {
        $this->updateRequestTemplate = $updateRequestTemplate;
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
            $this->serviceTemplate->namespace . '\\' . $this->serviceTemplate->class,
            $this->requestTrnasformerTemplate->namespace . '\\' . $this->requestTrnasformerTemplate->class,
            $this->responseTrnasformerTemplate->namespace . '\\' . $this->responseTrnasformerTemplate->class,
            $this->createRequestTemplate->namespace . '\\' . $this->createRequestTemplate->class,
            $this->updateRequestTemplate->namespace . '\\' . $this->updateRequestTemplate->class,
            $dto->class,
            $this->getConstructorClassAttribute($this->serviceTemplate->class),
            $this->getConstructorClassAttribute($this->requestTrnasformerTemplate->class),
            $this->getConstructorClassAttribute($this->responseTrnasformerTemplate->class),
            $this->getClassMethodAsParam($this->createRequestTemplate->class),
            $this->getClassMethodAsParam($this->updateRequestTemplate->class)
        );

        return $dto;
    }
}
