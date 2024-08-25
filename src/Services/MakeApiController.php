<?php

namespace Nikitinuser\LaravelMakeAllExtended\Services;

use Nikitinuser\LaravelMakeAllExtended\Services\MakeBase;

class MakeApiController extends MakeBase
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
        $path = __DIR__ . "/../templates/api_Controller.txt";
        $template = file_get_contents($path);

        $namespace = $this->getNamespace('Http\Controllers', $subFolders);
        $name = $modelName . "Controller";

        $template = sprintf(
            $template,
            $namespace,
            $name,
            '//Todo',
            $this->getCreateFormRequest(),
            $this->getUpdateFormRequest(),
        );

        $this->saveFile($name, $template, '/Http/Controllers/', $subFolders);

        $this->fillBaseClassInfo($name, $namespace);
        return $this->baseClassInfo;
    }

    private function getCreateFormRequest(): string
    {
        return '// Todo';
    }

    private function getUpdateFormRequest(): string
    {
        return '// Todo';
    }
}
