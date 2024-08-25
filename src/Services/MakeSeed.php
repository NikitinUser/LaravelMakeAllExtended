<?php

namespace Nikitinuser\LaravelMakeAllExtended\Services;

use Nikitinuser\LaravelMakeAllExtended\Services\MakeBase;

class MakeSeed extends MakeBase
{
    /**
     * @param string $modelName
     *
     * @return array
     */
    public function __invoke(string $modelName): array
    {
        $path = __DIR__ . "/../templates/Seeder.txt";
        $template = file_get_contents($path);

        $name = $modelName . "Seeder";

        $template = sprintf(
            $template,
            $name,
            '// Todo'
        );

        $namespace = $this->getNamespace('Database\Seeders');

        $this->saveFile($name, $template, '/../database/seeders/');

        $this->fillBaseClassInfo($name, $namespace);
        return $this->baseClassInfo;
    }
}
