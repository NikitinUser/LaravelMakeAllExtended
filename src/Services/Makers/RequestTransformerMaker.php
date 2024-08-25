<?php

namespace Nikitinuser\LaravelMakeAllExtended\Services\Makers;

use Nikitinuser\LaravelMakeAllExtended\Dto\TemplateDto;
use Nikitinuser\LaravelMakeAllExtended\Services\Makers\BaseMaker;
use Nikitinuser\LaravelMakeAllExtended\Services\Makers\TransformerTrait;

class RequestTransformerMaker extends BaseMaker
{
    use TransformerTrait;

    public const TEMPLATE_FILE = '/RequestTransformer.txt';
    public const POSTFIX = 'RequestTransformer';
    public const NAMESPACE_BASE = 'App\Http\Transformers\Request';
    public const RELATIVE_PATH_BASE = '/Http/Transformers/Request/';

    private TemplateDto $dtoTemplate;
}
