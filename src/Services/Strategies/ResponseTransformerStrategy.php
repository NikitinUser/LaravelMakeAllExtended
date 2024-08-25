<?php

namespace Nikitinuser\LaravelMakeAllExtended\Services\Strategies;

use Nikitinuser\LaravelMakeAllExtended\Dto\TemplateDto;
use Nikitinuser\LaravelMakeAllExtended\Services\Strategies\BaseStrategy;

class ResponseTransformerStrategy extends BaseStrategy
{
    public const TEMPLATE_FILE = '/ResponseTransformer.txt';
    public const POSTFIX = 'ResponseTransformer';
    public const NAMESPACE_BASE = 'App\Http\Transformers\Response';
    public const RELATIVE_PATH_BASE = '/Http/Transformers/Response/';

    private TemplateDto $dtoTemplate;

    public function setDtoTemplate(TemplateDto $dtoTemplate): self
    {
        $this->dtoTemplate = $dtoTemplate;
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
            $this->dtoTemplate->namespace . '\\' . $this->dtoTemplate->class,
            $dto->class,
        );

        return $dto;
    }
}
