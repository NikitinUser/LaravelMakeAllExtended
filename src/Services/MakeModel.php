<?php

namespace Nikitinuser\LaravelMakeAllExtended\Services;

use Nikitinuser\LaravelMakeAllExtended\Services\MakeBase;

class MakeModel extends MakeBase
{
    /**
     * @param string $modelName
     * @param array $modelColumns
     * @param string $subFolders
     *
     * @return array
     */
    public function __invoke(string $modelName, array $modelColumns, string $subFolders = ""): array
    {
        $path = __DIR__ . "/../templates/Model.txt";
        $template = file_get_contents($path);

        $namespace = $this->getNamespace('App\Models', $subFolders);

        $template = sprintf(
            $template,
            $namespace,
            $modelName,
            $this->getAttributes($modelColumns),
            $this->getCasts($modelColumns),
            $this->getFillable($modelColumns)
        );

        $this->saveFile($modelName, $template, '/Models/', $subFolders);

        $this->fillBaseClassInfo($modelName, $namespace);
        return $this->baseClassInfo;
    }

    private function getAttributes(array $modelColumns): string
    {
        $attributes = "";
        foreach ($modelColumns as $name => $properties) {
            if (!is_null($properties['default'])) {
                $attributes .= "'" . $name . "' => " . $properties['default'] . ",\n        ";
            }
        }

        return trim($attributes);
    }

    private function getCasts(array $modelColumns): string
    {
        $casts = "";
        foreach ($modelColumns as $name => $properties) {
            if ($properties['type_php'] === 'array') {
                $casts .= "'" . $name . "' => 'array',\n        ";
            }
        }

        return trim($casts);
    }

    private function getFillable(array $modelColumns): string
    {
        $fillable = "";
        foreach ($modelColumns as $name => $properties) {
            $fillable .= "'" . $name . "',\n        ";
        }

        return trim($fillable);
    }
}
