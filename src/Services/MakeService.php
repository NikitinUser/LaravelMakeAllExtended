<?php

namespace Nikitinuser\LaravelMakeAllExtended\Services;

use Nikitinuser\LaravelMakeAllExtended\Services\MakeBase;

class MakeService extends MakeBase
{
    /**
     * @param string $modelName
     * @param array $modelColumns
     * @param string $subFolders
     *
     * @return array
     */
    public function __invoke(string $modelName, string $repositoryNamespace, string $repositoryName, string $subFolders = ""): array
    {
        $path = __DIR__ . "/../templates/Service.txt";
        $template = file_get_contents($path);

        $namespace = $this->getNamespace('App\Services', $subFolders);
        $name = $modelName . "Service";

        $template = sprintf(
            $template,
            $namespace,
            $this->getUsing($repositoryNamespace, $repositoryName),
            $name,
            $this->getConstructorClassAttribute($repositoryName)
        );

        $this->saveFile($name, $template, '/Services/', $subFolders);

        $this->fillBaseClassInfo($name, $namespace);
        return $this->baseClassInfo;
    }
}
