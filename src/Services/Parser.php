<?php

namespace Nikitinuser\LaravelMakeAllExtended\Services;

class Parser
{
    /**
     * @param string $migrationPath
     *
     * @return array
     */
    public function __invoke(string $migrationPath): array
    {
        $columns = [];

        $file = fopen($migrationPath, 'r');
        while (!feof($file)) {
            $line = fgets($file);
            $type = "";
            $name = "";
            $nullable = false;
            $default = null;

            $bufLine = $line;

            if (
                !str_contains($line, '$table')
                || str_contains($line, 'Blueprint $table')
                || str_starts_with(trim($line), '//')
            ) {
                continue;
            }

            while (!str_contains($line, ';') && !feof($file)) {
                $line = fgets($file);
                $bufLine .= $line;
            }

            if (
                str_contains($bufLine, '->timestampsTz(')
                || str_contains($bufLine, '->timestamps(')
                || str_contains($bufLine, '->rememberToken(')
                || str_contains($bufLine, '->nullableTimestamps(')
            ) {
                continue;
            }

            $arrBufLine = explode("\n", $bufLine);
            $bufLine = "";
            for ($i = 0; $i < count($arrBufLine); $i++) {
                $bufLine .= trim($arrBufLine[$i]);
            }
            unset($arrBufLine);

            $substr = trim(explode('>', $bufLine)[1] ?? "");
            $type = trim((explode('(', $substr)[0] ?? ""));
            $substr = trim((explode('(', $substr)[1] ?? ""));
            $substrArr = explode("'", $substr);
            if (empty(trim($substrArr[1] ?? ""))) {
                $substrArr = explode("\"", $substr);
            }
            if (empty(trim($substrArr[1] ?? "")) && str_contains($substr, '::class')) {
                $substrArr = explode(":", $substr);
                $substrArr = explode("\\", $substrArr[0]);
                $name = $substrArr[count($substrArr) - 1];
                $name = lcfirst($name) . "_id";
            } else {
                $name = trim($substrArr[1] ?? "");
            }

            $specificType = null;
            if (str_contains($bufLine, '->id(')) {
                $specificType = "id";
            }

            if (!is_null($specificType)) {
                $type = $specificType;
                $name = $specificType;
            }

            if (str_contains($bufLine, '->nullable()')) {
                $nullable = true;
            }

            if (str_contains($bufLine, '->default(')) {
                $bufArr = explode('>', $bufLine);
                for ($i = 0; $i < count($bufArr); $i++) {
                    if (str_contains($bufArr[$i], 'default(')) {
                        $default = explode("(", $bufArr[$i])[1] ?? "";
                        $default = explode(")", $default)[0] ?? "";
                        break;
                    }
                }
            }

            $typePhp = "";
            if ($type === 'boolean') {
                $typePhp = "bool";
            } elseif (in_array($type, ['float', 'decimal', 'double'])) {
                $typePhp = "float";
            } elseif (in_array($type, ['enum', 'json', 'jsonb', 'set'])) {
                $typePhp = "array";
            } elseif (
                str_contains($type, 'ncrement')
                || str_contains($type, 'int')
                || in_array($type, ['id', 'foreignId', 'foreignIdFor'])
            ) {
                $typePhp = "int";
            } else {
                $typePhp = "string";
            }

            $nameArr = explode('_', $name);
            $namePhp = $nameArr[0];

            for ($i = 1; $i < count($nameArr); $i++) {
                $namePhp .= ucfirst($nameArr[$i]);
            }

            $columns[$name] = [
                "type" => $type,
                "type_php" => $typePhp,
                "nullable" => $nullable,
                "default" => $default,
                "name_php" => $namePhp,
            ];
        }
        fclose($file);

        return $columns;
    }
}
