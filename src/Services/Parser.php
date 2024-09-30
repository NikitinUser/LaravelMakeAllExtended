<?php

namespace Nikitinuser\LaravelMakeAllExtended\Services;

class Parser
{
    /**
     * @param string $migrationPath
     *
     * @return array
     */
    public function parse(string $migrationPath): array
    {
        $columns = [];

        $file = fopen($migrationPath, 'r');
        while (!feof($file)) {
            $line = trim(fgets($file));
            $bufLine = $line;

            if ($this->isNotTableFields($line)) {
                continue;
            }

            while (!str_contains($line, ';') && !feof($file)) {
                $line = fgets($file);
                $bufLine .= $line;
            }

            if ($this->isNotAllowTypesField($bufLine)) {
                continue;
            }

            $bufLine = $this->toOneLine($bufLine);

            $type = $this->getType($bufLine);

            $name = $this->getName($bufLine);
            if (empty($name)) {
                $name = $type;
            }

            $nullable = $this->isNullable($bufLine);

            $default = $this->getDefault($bufLine);

            $typePhp = $this->toPhpType($type);

            $namePhp = $this->toCamelCase($name);

            $columns[$name] = [
                'type' => $type,
                'type_php' => $typePhp,
                'nullable' => $nullable,
                'default' => $default,
                'name_php' => $namePhp,
            ];
        }
        fclose($file);

        return $columns;
    }

    /**
     * @param string $line
     *
     * @return bool
     */
    private function isNotTableFields(string $line): bool
    {
        return !str_contains($line, '$table')
            || str_contains($line, 'Blueprint $table')
            || str_starts_with($line, '//');
    }

    /**
     * @param string $line
     *
     * @return bool
     */
    private function isNotAllowTypesField(string $line): bool
    {
        return str_contains($line, '->timestampsTz(')
            || str_contains($line, '->timestamps(')
            || str_contains($line, '->rememberToken(')
            || str_contains($line, '->nullableTimestamps(');
    }

    /**
     * @param string $line
     *
     * @return string
     */
    private function toOneLine(string $line): string
    {
        $parts = explode("\n", $line);
        $line = '';
        for ($i = 0; $i < count($parts); $i++) {
            $line .= trim($parts[$i]);
        }
        return $line;
    }

    /**
     * @param string $line
     *
     * @return string
     */
    private function getType(string $line): string
    {
        $substr = trim(explode('>', $line)[1] ?? '');

        $type = trim((explode('(', $substr)[0] ?? ''));

        $specificType = null;
        if (str_contains($line, '->id(')) {
            $specificType = 'id';
        }

        if (!is_null($specificType)) {
            $type = $specificType;
        }

        return $type;
    }

    /**
     * @param string $line
     *
     * @return string
     */
    private function getName(string $line): string
    {
        $substr = trim(explode('>', $line)[1] ?? '');
        $substr = trim((explode('(', $substr)[1] ?? ''));

        $substrArr = explode("'", $substr);
        if (empty(trim($substrArr[1] ?? ''))) {
            $substrArr = explode("\"", $substr);
        }

        if (empty(trim($substrArr[1] ?? '')) && str_contains($substr, '::class')) {
            $substrArr = explode(':', $substr);
            $substrArr = explode("\\", $substrArr[0]);
            $name = $substrArr[count($substrArr) - 1];
            $name = lcfirst($name) . '_id';
        } else {
            $name = trim($substrArr[1] ?? '');
        }

        return $name;
    }

    /**
     * @param string $line
     *
     * @return bool
     */
    private function isNullable(string $line): bool
    {
        return str_contains($line, '->nullable()');
    }

    /**
     * @param string $line
     *
     * @return null|string
     */
    private function getDefault(string $line): ?string
    {
        $default = null;

        if (str_contains($line, '->default(')) {
            $bufArr = explode('>', $line);
            for ($i = 0; $i < count($bufArr); $i++) {
                if (str_contains($bufArr[$i], 'default(')) {
                    $default = explode('(', $bufArr[$i])[1] ?? '';
                    $default = explode(')', $default)[0] ?? '';
                    break;
                }
            }
        }

        return $default;
    }

    /**
     * @param string $name
     *
     * @return string
     */
    private function toCamelCase(string $name): string
    {
        $nameArr = explode('_', $name);
        $namePhp = $nameArr[0];
        for ($i = 1; $i < count($nameArr); $i++) {
            $namePhp .= ucfirst($nameArr[$i]);
        }

        return $namePhp;
    }

    /**
     * @param string $type
     *
     * @return string
     */
    private function toPhpType(string $type): string
    {
        $typePhp = '';

        if ($type === 'boolean') {
            $typePhp = 'bool';
        } elseif (in_array($type, ['float', 'decimal', 'double'])) {
            $typePhp = 'float';
        } elseif (in_array($type, ['enum', 'json', 'jsonb', 'set'])) {
            $typePhp = 'array';
        } elseif (
            str_contains($type, 'ncrement')
            || str_contains($type, 'int')
            || in_array($type, ['id', 'foreignId', 'foreignIdFor'])
        ) {
            $typePhp = 'int';
        } else {
            $typePhp = 'string';
        }

        return $typePhp;
    }
}
