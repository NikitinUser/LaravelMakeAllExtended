<?php

namespace Nikitinuser\LaravelMakeAllExtended\Services;

use Nikitinuser\LaravelMakeAllExtended\Dto\MakeAllDto;
use Nikitinuser\LaravelMakeAllExtended\Helpers\Saver;
use Nikitinuser\LaravelMakeAllExtended\Services\Makers\ApiControllerMaker;
use Nikitinuser\LaravelMakeAllExtended\Services\Makers\DtoMaker;
use Nikitinuser\LaravelMakeAllExtended\Services\Makers\FactoryMaker;
use Nikitinuser\LaravelMakeAllExtended\Services\Makers\InvokableControllerMaker;
use Nikitinuser\LaravelMakeAllExtended\Services\Makers\FormRequestMaker;
use Nikitinuser\LaravelMakeAllExtended\Services\Makers\ModelMaker;
use Nikitinuser\LaravelMakeAllExtended\Services\Makers\RepositoryMaker;
use Nikitinuser\LaravelMakeAllExtended\Services\Makers\RequestTransformerMaker;
use Nikitinuser\LaravelMakeAllExtended\Services\Makers\ResponseTransformerMaker;
use Nikitinuser\LaravelMakeAllExtended\Services\Makers\SeedMaker;
use Nikitinuser\LaravelMakeAllExtended\Services\Makers\ServiceMaker;

class FileMaker
{
    private array $templates = [];

    public function __construct(
        private ApiControllerMaker $apiControllerMaker,
        private DtoMaker $dtoMaker,
        private FactoryMaker $factoryMaker,
        private InvokableControllerMaker $invokableControllerMaker,
        private FormRequestMaker $formRequestMaker,
        private ModelMaker $modelMaker,
        private RepositoryMaker $repositoryMaker,
        private RequestTransformerMaker $requestTransformerMaker,
        private ResponseTransformerMaker $responseTransformerMaker,
        private SeedMaker $seedMaker,
        private ServiceMaker $serviceMaker
    ) {
    }

    /**
     * @TODO refactoring
     */
    public function make(MakeAllDto $dto, array $columns): void
    {
        $modelDto = $this->modelMaker
            ->setColumns($columns)
            ->setModelName($dto->modelName)
            ->make($dto->subFolders);
        $this->templates[] = $modelDto;
        unset($columns);

        $this->templates[] = $this->factoryMaker
            ->setModelTemplateDto($modelDto)
            ->make();

        $this->templates[] = $this->seedMaker
            ->setModelTemplateDto($modelDto)
            ->make();

        $repoDto = $this->repositoryMaker
            ->setModelTemplateDto($modelDto)
            ->make($dto->subFolders);
        $this->templates[] = $repoDto;

        $dtoTemplate = $this->dtoMaker
            ->setModelTemplateDto($modelDto)
            ->make($dto->subFolders);
        $this->templates[] = $dtoTemplate;

        $serviceDto = $this->serviceMaker
            ->setModelTemplateDto($modelDto)
            ->setRepositoryTempalte($repoDto)
            ->setDtoTemplate($dtoTemplate)
            ->make($dto->subFolders);
        $this->templates[] = $serviceDto;

        if (empty($dto->api) && empty($dto->invokable)) {
            $this->saveTemplates();
            return;
        }

        $requestTransformerDto = $this->requestTransformerMaker
            ->setModelTemplateDto($modelDto)
            ->setDtoTemplate($dtoTemplate)
            ->make($dto->subFolders);
        $this->templates[] = $requestTransformerDto;

        $responseTransformerDto = $this->responseTransformerMaker
            ->setModelTemplateDto($modelDto)
            ->setDtoTemplate($dtoTemplate)
            ->make($dto->subFolders);
        $this->templates[] = $responseTransformerDto;

        if (!empty($dto->api)) {
            $createRequestDto = $this->formRequestMaker
                ->setModelTemplateDto($modelDto)
                ->setPrefix(FormRequestMaker::CREATE_PREFIX)
                ->make($dto->subFolders);
            $this->templates[] = $createRequestDto;

            $updateRequestDto = $this->formRequestMaker
                ->setModelTemplateDto($modelDto)
                ->setPrefix(FormRequestMaker::UPDATE_PREFIX)
                ->make($dto->subFolders);
            $this->templates[] = $updateRequestDto;

            $this->templates[] = $this->apiControllerMaker
                ->setModelTemplateDto($modelDto)
                ->setServiceTempalte($serviceDto)
                ->setRequestTrnasformerTemplate($requestTransformerDto)
                ->setResponseTrnasformerTemplate($responseTransformerDto)
                ->setCreateRequestTemplate($createRequestDto)
                ->setUpdateRequestTemplate($updateRequestDto)
                ->make($dto->subFolders);
        } else {
            $this->templates[] = $this->invokableControllerMaker
                ->setModelTemplateDto($modelDto)
                ->setServiceTempalte($serviceDto)
                ->setRequestTrnasformerTemplate($requestTransformerDto)
                ->setResponseTrnasformerTemplate($responseTransformerDto)
                ->make($dto->subFolders);
        }

        $this->saveTemplates();
    }

    /**
     * @return void
     */
    private function saveTemplates()
    {
        foreach ($this->templates as $dto) {
            Saver::save($dto);
        }
    }
}
