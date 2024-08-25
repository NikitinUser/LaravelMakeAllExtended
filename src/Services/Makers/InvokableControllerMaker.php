<?php

namespace Nikitinuser\LaravelMakeAllExtended\Services\Makers;

use Nikitinuser\LaravelMakeAllExtended\Dto\TemplateDto;
use Nikitinuser\LaravelMakeAllExtended\Services\Makers\BaseController;

class InvokableControllerMaker extends BaseController
{
    public const TEMPLATE_FILE = '/invoke_Controller.txt';

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
            $dto->class,
            $this->getConstructorClassAttribute($this->serviceTemplate->class),
            $this->getConstructorClassAttribute($this->requestTrnasformerTemplate->class),
            $this->getConstructorClassAttribute($this->responseTrnasformerTemplate->class)
        );

        return $dto;
    }
}
