<?php

namespace Nikitinuser\LaravelMakeAllExtended\Services;

use Nikitinuser\LaravelMakeAllExtended\Services\MakeBase;

class MakeDto extends MakeBase
{
    /**
     * @param string $modelName
     * @param string $modelNamespace
     * @param string $subFolders
     *
     * @return array
     */
    public function __invoke(string $modelName, array $modelColumns, string $subFolders = ""): array
    {
        $path = __DIR__ . "/../templates/Dto.txt";
        $template = file_get_contents($path);

        $namespace = $this->getNamespace('App\Dto',$subFolders);
        $name = $modelName . "Dto";

        $template = sprintf(
            $template,
            $namespace,
            $name,
            $this->getAttributes($modelColumns)
        );

        $this->saveFile($name, $template, '/Dto/', $subFolders);

        $this->fillBaseClassInfo($name, $namespace);
        return $this->baseClassInfo;
    }

    private function getAttributes(array $modelColumns): string
    {
        $attributes = '';

        foreach ($modelColumns as $name => $properties) {
            $attributes .= "public ?" . $properties['type_php'] . " " . $name . " = null;\n        ";
        }

        return $attributes;
    }
}
