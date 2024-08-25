<?php

namespace Nikitinuser\LaravelMakeAllExtended\Services;

class MakeBase
{
    protected array $baseClassInfo = [
        'className' => '',
        'namespace' => '',
    ];

    protected function getNamespace(string $base, ?string $subFolders = null): string
    {
        $namespace = $base;
        if (!empty($subFolders)) {
            $namespace .= '\\' . $subFolders;
        }

        return $namespace;
    }

    protected function saveFile(string $filename, string $template, string $basePath, string $subFolders = ''): void
    {
        $savePath = app_path();
        if (!is_dir($savePath)) {
            mkdir($savePath);
        }

        if (!empty($subFolders)) {
            $subFoldersArr = explode('/', ($basePath . $subFolders));
            for ($i = 0; $i < count($subFoldersArr); $i++) {
                $savePath .= $subFoldersArr[$i] . "/";
                if (!is_dir($savePath)) {
                    mkdir($savePath);
                }
            }
        }

        $savePath .= $filename . ".php";

        file_put_contents($savePath, $template);
    }

    protected function getUsing(string $namespace, string $class): string
    {
        return 'use \\' . $namespace . '\\' . $class . '\\' . ';';
    }

    protected function fillBaseClassInfo(string $className, string $namespace): void
    {
        $this->baseClassInfo['className'] = $className;
        $this->baseClassInfo['namespace'] = $namespace;
    }

    protected function getConstructorClassAttribute(string $class, string $mode = 'private'): string
    {
        return $mode . ' ' . $class . ' ' . lcfirst($class);
    }
}
