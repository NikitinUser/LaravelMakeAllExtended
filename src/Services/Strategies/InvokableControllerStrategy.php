<?php

namespace Nikitinuser\LaravelMakeAllExtended\Services\Strategies;

use Nikitinuser\LaravelMakeAllExtended\Dto\TemplateDto;
use Nikitinuser\LaravelMakeAllExtended\Services\Strategies\BaseStrategy;

class InvokableControllerStrategy extends BaseStrategy
{
    public const TEMPLATE_FILE = '/invoke_Controller.txt';
    public const POSTFIX = 'Controller';
    public const NAMESPACE_BASE = 'App\Http\Controllers';
    public const RELATIVE_PATH_BASE = '/Http/Controllers/';

    private TemplateDto $serviceTemplate;
    private TemplateDto $requestTrnasformerTemplate;
    private TemplateDto $responseTrnasformerTemplate;

    public function setServiceTempalte(TemplateDto $serviceTemplate): self
    {
        $this->serviceTemplate = $serviceTemplate;
        return $this;
    }

    public function setRequestTrnasformerTemplate(TemplateDto $requestTrnasformerTemplate): self
    {
        $this->requestTrnasformerTemplate = $requestTrnasformerTemplate;
        return $this;
    }

    public function setResponseTrnasformerTemplate(TemplateDto $responseTrnasformerTemplate): self
    {
        $this->responseTrnasformerTemplate = $responseTrnasformerTemplate;
        return $this;
    }

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
            $this->serviceTemplate->namespace . '\\' . $this->serviceTemplate->class,
            $this->requestTrnasformerTemplate->namespace . '\\' . $this->requestTrnasformerTemplate->class,
            $this->responseTrnasformerTemplate->namespace . '\\' . $this->responseTrnasformerTemplate->class,
            $dto->class,
            $this->getConstructorClassAttribute($this->serviceTemplate->class),
            $this->getConstructorClassAttribute($this->requestTrnasformerTemplate->class),
            $this->getConstructorClassAttribute($this->responseTrnasformerTemplate->class)
        );

        return $dto;
    }
}
