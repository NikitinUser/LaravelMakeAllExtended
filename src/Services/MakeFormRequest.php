<?php

namespace Nikitinuser\LaravelMakeAllExtended\Services;

use Nikitinuser\LaravelMakeAllExtended\Services\MakeBase;

class MakeFormRequest extends MakeBase
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
        $path = __DIR__ . "/../templates/FormRequest.txt";
        $template = file_get_contents($path);

        $namespace = $this->getNamespace($subFolders);
        $namespace = $this->getNamespace('Http\Requests', $subFolders);
        $name = $modelName . "Request";

        $template = sprintf(
            $template,
            $namespace,
            $name,
            '// Todo'
        );

        $this->saveFile($name, $template, '/Http/Requests/', $subFolders);

        $this->fillBaseClassInfo($name, $namespace);
        return $this->baseClassInfo;
    }
}
