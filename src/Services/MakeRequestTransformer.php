<?php

namespace Nikitinuser\LaravelMakeAllExtended\Services;

use Nikitinuser\LaravelMakeAllExtended\Services\MakeBase;

class MakeRequestTransformer extends MakeBase
{
    /**
     * @param string $modelName
     * @param array $modelColumns
     * @param string $subFolders
     *
     * @return array
     */
    public function __invoke(string $modelName, string $dtoNamespace, string $dtoName, string $subFolders = ""): array
    {
        $path = __DIR__ . "/../templates/RequestTransformer.txt";
        $template = file_get_contents($path);

        $namespace = $this->getNamespace('Http\Transformers\Request', $subFolders);
        $name = $modelName . "RequestTransformer";

        $template = sprintf(
            $template,
            $namespace,
            $dtoNamespace . '\\' . $dtoName,
            $name
        );

        $this->saveFile($name, $template, '/Http/Transformers/Request/', $subFolders);

        $this->fillBaseClassInfo($name, $namespace);
        return $this->baseClassInfo;
    }
}
