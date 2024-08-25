<?php

namespace Nikitinuser\LaravelMakeAllExtended\Services;

use Nikitinuser\LaravelMakeAllExtended\Services\MakeBase;

class MakeFactory extends MakeBase
{
    /**
     * @param string $modelName
     * @param array $modelColumns
     *
     * @return array
     */
    public function __invoke(string $modelName, string $modelNamespace): array
    {
        $path = __DIR__ . "/../templates/Factory.txt";
        $template = file_get_contents($path);

        $name = $modelName . "Factory";

        $template = sprintf(
            $template,
            $modelNamespace . '\\' . $name,
            $name,
            '// Todo'
        );

        $namespace = $this->getNamespace('Database\Factories');

        $this->saveFile($name, $template, '/../database/factories/');

        $this->fillBaseClassInfo($name, $namespace);
        return $this->baseClassInfo;
    }
}
