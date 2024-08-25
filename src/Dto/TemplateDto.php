<?php

namespace Nikitinuser\LaravelMakeAllExtended\Dto;

class TemplateDto
{
    public string $class;
    public string $namespace;
    public string $relativePath;
    public string $content;
    public array $modelColumns = [];
}
