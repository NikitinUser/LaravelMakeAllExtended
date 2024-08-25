<?php

namespace Nikitinuser\LaravelMakeAllExtended\Services\Makers;

use Nikitinuser\LaravelMakeAllExtended\Dto\TemplateDto;
use Nikitinuser\LaravelMakeAllExtended\Services\Makers\BaseMaker;

class FormRequestMaker extends BaseMaker
{
    public const TEMPLATE_FILE = '/FormRequest.txt';
    public const POSTFIX = 'Request';
    public const NAMESPACE_BASE = 'App\Http\Requests';
    public const RELATIVE_PATH_BASE = '/Http/Requests/';

    public const CREATE_PREFIX = 'Create';
    public const UPDATE_PREFIX = 'Update';

    private string $prefix = '';

    /**
     * @param string $prefix
     *
     * @return self
     */
    public function setPrefix(string $prefix): self
    {
        $this->prefix = $prefix;
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

        $dto->class = $this->prefix . $dto->class;

        $dto->content = sprintf(
            $template,
            $dto->namespace,
            $dto->class,
            $this->getRules()
        );

        return $dto;
    }

    /**
     * @return string
     */
    private function getRules(): string
    {
        $rules = '';

        foreach ($this->modelTemplateDto->modelColumns as $name => $properties) {
            $rules .= "'" . $name . "' => 'required|" . $properties['type_php'] . "',\n\t\t\t";
        }

        return $rules;
    }
}
