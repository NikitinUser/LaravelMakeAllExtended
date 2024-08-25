<?php

namespace Nikitinuser\LaravelMakeAllExtended\Services\Makers;

use Nikitinuser\LaravelMakeAllExtended\Dto\TemplateDto;
use Nikitinuser\LaravelMakeAllExtended\Services\Makers\BaseMaker;
use Nikitinuser\LaravelMakeAllExtended\Services\Makers\TransformerTrait;

class ResponseTransformerMaker extends BaseMaker
{
    use TransformerTrait;

    public const TEMPLATE_FILE = '/ResponseTransformer.txt';
    public const POSTFIX = 'ResponseTransformer';
    public const NAMESPACE_BASE = 'App\Http\Transformers\Response';
    public const RELATIVE_PATH_BASE = '/Http/Transformers/Response/';

    private TemplateDto $dtoTemplate;
}
