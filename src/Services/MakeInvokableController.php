<?php

namespace Nikitinuser\LaravelMakeAllExtended\Services;

use Nikitinuser\LaravelMakeAllExtended\Services\MakeBase;

class MakeInvokableController extends MakeBase
{
    /**
     * @param string $modelName
     * @param array $modelColumns
     * @param string $subFolders
     *
     * @return array
     */
    public function __invoke(string $modelName, string $subFolders = ""): array
    {
        $path = __DIR__ . "/../templates/invoke_Controller.txt";
        $template = file_get_contents($path);

        $namespace = $this->getNamespace('Http\Controllers', $subFolders);
        $name = $modelName . "Controller";

        $template = sprintf(
            $template,
            $namespace,
            $name
        );

        $this->saveFile($name, $template, '/Http/Controllers/', $subFolders);

        $this->fillBaseClassInfo($name, $namespace);
        return $this->baseClassInfo;
    }
}
