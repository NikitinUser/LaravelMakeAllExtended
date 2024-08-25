<?php

namespace Nikitinuser\LaravelMakeAllExtended\Services;

use Nikitinuser\LaravelMakeAllExtended\Services\MakeBase;

class MakeRepository extends MakeBase
{
    /**
     * @param string $modelName
     * @param string $modelNamespace
     * @param string $subFolders
     *
     * @return array
     */
    public function __invoke(string $modelName, string $modelNamespace, string $subFolders = ""): array
    {
        $path = __DIR__ . "/../templates/Repository.txt";
        $template = file_get_contents($path);

        $namespace = $this->getNamespace('App\Repositories', $subFolders);
        $name = $modelName . "Repository";

        $template = sprintf(
            $template,
            $namespace,
            $this->getUsing($modelNamespace, $modelName),
            $name,
            $modelName
        );

        $this->saveFile($name, $template, '/Repositories/', $subFolders);

        $this->fillBaseClassInfo($name, $namespace);
        return $this->baseClassInfo;
    }
}
