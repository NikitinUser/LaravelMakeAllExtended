<?php

namespace Nikitinuser\LaravelMakeAllExtended\Services\Makers;

use Nikitinuser\LaravelMakeAllExtended\Dto\TemplateDto;
use Nikitinuser\LaravelMakeAllExtended\Services\Makers\BaseMaker;

abstract class BaseController extends BaseMaker
{
    public const TEMPLATE_FILE = '/api_Controller.txt';
    public const POSTFIX = 'Controller';
    public const NAMESPACE_BASE = 'App\Http\Controllers';
    public const RELATIVE_PATH_BASE = '/Http/Controllers/';

    protected TemplateDto $serviceTemplate;
    protected TemplateDto $requestTrnasformerTemplate;
    protected TemplateDto $responseTrnasformerTemplate;

    /**
     * @param TemplateDto $serviceTemplate
     *
     * @return self
     */
    public function setServiceTempalte(TemplateDto $serviceTemplate): self
    {
        $this->serviceTemplate = $serviceTemplate;
        return $this;
    }

    /**
     * @param TemplateDto $requestTrnasformerTemplate
     *
     * @return self
     */
    public function setRequestTrnasformerTemplate(TemplateDto $requestTrnasformerTemplate): self
    {
        $this->requestTrnasformerTemplate = $requestTrnasformerTemplate;
        return $this;
    }

    /**
     * @param TemplateDto $responseTrnasformerTemplate
     *
     * @return self
     */
    public function setResponseTrnasformerTemplate(TemplateDto $responseTrnasformerTemplate): self
    {
        $this->responseTrnasformerTemplate = $responseTrnasformerTemplate;
        return $this;
    }
}
