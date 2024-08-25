<?php

namespace Nikitinuser\LaravelMakeAllExtended\Services\Makers;

use Nikitinuser\LaravelMakeAllExtended\Dto\TemplateDto;
use Nikitinuser\LaravelMakeAllExtended\Services\Makers\BaseMaker;

class ModelMaker extends BaseMaker
{
    public const TEMPLATE_FILE = '/Model.txt';
    public const POSTFIX = '';
    public const NAMESPACE_BASE = 'App\Models';
    public const RELATIVE_PATH_BASE = '/Models/';

    private array $columns;
    private string $modelName;

    /**
     * @param array $columns
     *
     * @return self
     */
    public function setColumns(array $columns): self
    {
        $this->columns = $columns;
        return $this;
    }

    /**
     * @param string $modelName
     *
     * @return self
     */
    public function setModelName(string $modelName): self
    {
        $this->modelName = $modelName;
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
            $this->modelName,
            self::POSTFIX,
            self::NAMESPACE_BASE,
            self::RELATIVE_PATH_BASE,
            $subFolders
        );

        $dto->modelColumns = $this->columns;

        $dto->content = sprintf(
            $template,
            $dto->namespace,
            $dto->class,
            $this->getAttributes($this->columns),
            $this->getCasts($this->columns),
            $this->getFillable($this->columns)
        );

        return $dto;
    }

    /**
     * @param array $modelColumns
     *
     * @return string
     */
    private function getAttributes(array $modelColumns): string
    {
        $attributes = '';
        foreach ($modelColumns as $name => $properties) {
            if (!is_null($properties['default'])) {
                $attributes .= "'" . $name . "' => " . $properties['default'] . ",\n\t\t";
            }
        }

        return trim($attributes);
    }

    /**
     * @param array $modelColumns
     *
     * @return string
     */
    private function getCasts(array $modelColumns): string
    {
        $casts = '';
        foreach ($modelColumns as $name => $properties) {
            if ($properties['type_php'] === 'array') {
                $casts .= "'" . $name . "' => 'array',\n\t\t";
            }
        }

        return trim($casts);
    }

    /**
     * @param array $modelColumns
     *
     * @return string
     */
    private function getFillable(array $modelColumns): string
    {
        $fillable = '';
        foreach ($modelColumns as $name => $properties) {
            $fillable .= "'" . $name . "',\n\t\t";
        }

        return trim($fillable);
    }
}
