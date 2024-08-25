<?php

namespace Nikitinuser\LaravelMakeAllExtended\Helpers;

use Nikitinuser\LaravelMakeAllExtended\Dto\TemplateDto;

class Saver
{
    public const PHP_EXTENTION = '.php';

    /**
     * @param TemplateDto $dto
     *
     * @return void
     */
    public static function save(TemplateDto $dto, string $extention = self::PHP_EXTENTION): void
    {
        $savePath = config('make_all_extended.app_path');
        if (!is_dir($savePath)) {
            mkdir($savePath);
        }

        $folders = explode('/', $dto->relativePath);

        for ($i = 0; $i < count($folders); $i++) {
            $savePath .= $folders[$i] . '/';
            if (!is_dir($savePath)) {
                mkdir($savePath);
            }
        }

        $savePath .= $dto->class . $extention;

        file_put_contents($savePath, $dto->content);
    }
}
