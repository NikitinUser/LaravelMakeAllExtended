<?php

namespace Nikitinuser\LaravelMakeAllExtended\Services;

class MakeModel
{
    /**
     * @param string $modelName
     * @param array $modelColumns
     * @param string $subFolders
     *
     * @return void
     */
    public function __invoke(string $modelName, array $modelColumns, string $subFolders = ""): void
    {
        $path = __DIR__ . "/../templates/Model.txt";
        $template = file_get_contents($path);

        $namespace = 'App\Models';

        if (!empty($subFolders)) {
            $namespace .= '\\' . $subFolders;
        }

        $className = $modelName;
        $attributes = '// Todo';
        $casts = '// Todo';
        $fillable = '// Todo';

        $template = sprintf(
            $template,
            $namespace,
            $className,
            $attributes,
            $casts,
            $fillable
        );

        $savePath = app_path() . "/Model/";
        if (!empty($subFolders)) {
            $savePath .= $subFolders . "/";
        }
        $savePath .= $modelName . ".php";

        file_put_contents($savePath, $template);
    }
}
