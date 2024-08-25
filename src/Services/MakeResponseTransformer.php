<?php

namespace Nikitinuser\LaravelMakeAllExtended\Services;

use Nikitinuser\LaravelMakeAllExtended\Services\MakeBase;

class MakeResponseTransformer extends MakeBase
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
        $path = __DIR__ . "/../templates/ResponseTransformer.txt";
        $template = file_get_contents($path);

        $namespace = $this->getNamespace('Http\Transformers\Response', $subFolders);
        $name = $modelName . "ResponseTransformer";

        $template = sprintf(
            $template,
            $namespace,
            $dtoNamespace . '\\' . $dtoName,
            $name
        );

        $this->saveFile($name, $template, '/Http/Transformers/Response/', $subFolders);

        $this->fillBaseClassInfo($name, $namespace);
        return $this->baseClassInfo;
    }
}
