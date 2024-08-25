<?php

namespace Nikitinuser\LaravelMakeAllExtended\Services\Strategies;

use Nikitinuser\LaravelMakeAllExtended\Dto\TemplateDto;
use Nikitinuser\LaravelMakeAllExtended\Services\Strategies\BaseStrategy;

class FormRequestStrategy extends BaseStrategy
{
    public const TEMPLATE_FILE = '/FormRequest.txt';
    public const POSTFIX = 'Request';
    public const NAMESPACE_BASE = 'App\Http\Requests';
    public const RELATIVE_PATH_BASE = '/Http/Requests/';

    public const CREATE_PREFIX = 'Create';
    public const UPDATE_PREFIX = 'Update';

    private string $prefix = '';

    public function setPrefix(string $prefix): self
    {
        $this->prefix = $prefix;
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

        $dto->class = $this->prefix . $dto->class;

        $dto->content = sprintf(
            $template,
            $dto->namespace,
            $dto->class,
            $this->getRules()
        );

        return $dto;
    }

    private function getRules(): string
    {
        $rules = '';

        foreach ($this->modelTemplateDto->modelColumns as $name => $properties) {
            $rules .= "'" . $name . "' => 'required|" . $properties['type_php'] . "',\n\t\t\t";
        }

        return $rules;
    }
}
