<?php

namespace Nikitinuser\LaravelMakeAllExtended\Services;

use Nikitinuser\LaravelMakeAllExtended\Dto\MakeAllDto;
use Nikitinuser\LaravelMakeAllExtended\Helpers\Saver;
use Nikitinuser\LaravelMakeAllExtended\Services\Strategies\ApiControllerStrategy;
use Nikitinuser\LaravelMakeAllExtended\Services\Strategies\DtoStrategy;
use Nikitinuser\LaravelMakeAllExtended\Services\Strategies\FactoryStrategy;
use Nikitinuser\LaravelMakeAllExtended\Services\Strategies\InvokableControllerStrategy;
use Nikitinuser\LaravelMakeAllExtended\Services\Strategies\FormRequestStrategy;
use Nikitinuser\LaravelMakeAllExtended\Services\Strategies\ModelStrategy;
use Nikitinuser\LaravelMakeAllExtended\Services\Strategies\RepositoryStrategy;
use Nikitinuser\LaravelMakeAllExtended\Services\Strategies\RequestTransformerStrategy;
use Nikitinuser\LaravelMakeAllExtended\Services\Strategies\ResponseTransformerStrategy;
use Nikitinuser\LaravelMakeAllExtended\Services\Strategies\SeedStrategy;
use Nikitinuser\LaravelMakeAllExtended\Services\Strategies\ServiceStrategy;
use Nikitinuser\LaravelMakeAllExtended\Services\Parser;

class MakeAll
{
    private array $templates = [];

    public function __construct(
        private ApiControllerStrategy $apiControllerStrategy,
        private DtoStrategy $dtoStrategy,
        private FactoryStrategy $factoryStrategy,
        private InvokableControllerStrategy $invokableControllerStrategy,
        private FormRequestStrategy $formRequestStrategy,
        private ModelStrategy $modelStrategy,
        private RepositoryStrategy $repositoryStrategy,
        private RequestTransformerStrategy $requestTransformerStrategy,
        private ResponseTransformerStrategy $responseTransformerStrategy,
        private SeedStrategy $seedStrategy,
        private ServiceStrategy $serviceStrategy,
        private Parser $parser,
    ) {
    }

    public function handle(MakeAllDto $dto): void
    {
        $this->makeDtos($dto);
        $this->saveTemplates();
    }

    public function makeDtos(MakeAllDto $dto)
    {
        $path = $this->getMigrationPath($dto->migrationFilename, $dto->migrationPath);

        $columns = ($this->parser)($path);

        $modelDto = $this->modelStrategy
            ->setColumns($columns)
            ->setModelName($dto->modelName)
            ->make($dto->subFolders);
        $this->templates[] = $modelDto;
        unset($columns);

        $this->templates[] = $this->factoryStrategy
            ->setModelTemplateDto($modelDto)
            ->make();

        $this->templates[] = $this->seedStrategy
            ->setModelTemplateDto($modelDto)
            ->make();

        $repoDto = $this->repositoryStrategy
            ->setModelTemplateDto($modelDto)
            ->make($dto->subFolders);
        $this->templates[] = $repoDto;

        $dtoTemplate = $this->dtoStrategy
            ->setModelTemplateDto($modelDto)
            ->make($dto->subFolders);
        $this->templates[] = $dtoTemplate;

        $requestTransformerDto = $this->requestTransformerStrategy
            ->setModelTemplateDto($modelDto)
            ->setDtoTemplate($dtoTemplate)
            ->make($dto->subFolders);
        $this->templates[] = $requestTransformerDto;

        $responseTransformerDto = $this->responseTransformerStrategy
            ->setModelTemplateDto($modelDto)
            ->setDtoTemplate($dtoTemplate)
            ->make($dto->subFolders);
        $this->templates[] = $responseTransformerDto;

        $serviceDto = $this->serviceStrategy
            ->setModelTemplateDto($modelDto)
            ->setRepositoryTempalte($repoDto)
            ->setDtoTemplate($dtoTemplate)
            ->make($dto->subFolders);
        $this->templates[] = $serviceDto;

        if (!empty($dto->api)) {
            $createRequestDto = $this->formRequestStrategy
                ->setModelTemplateDto($modelDto)
                ->setPrefix(FormRequestStrategy::CREATE_PREFIX)
                ->make($dto->subFolders);
            $this->templates[] = $createRequestDto;

            $updateRequestDto = $this->formRequestStrategy
                ->setModelTemplateDto($modelDto)
                ->setPrefix(FormRequestStrategy::UPDATE_PREFIX)
                ->make($dto->subFolders);
            $this->templates[] = $updateRequestDto;

            $this->templates[] = $this->apiControllerStrategy
                ->setModelTemplateDto($modelDto)
                ->setServiceTempalte($serviceDto)
                ->setRequestTrnasformerTemplate($requestTransformerDto)
                ->setResponseTrnasformerTemplate($responseTransformerDto)
                ->setCreateRequestTemplate($createRequestDto)
                ->setUpdateRequestTemplate($updateRequestDto)
                ->make($dto->subFolders);
        } elseif (!empty($dto->invokable)) {
            $this->templates[] = $this->invokableControllerStrategy
                ->setModelTemplateDto($modelDto)
                ->setServiceTempalte($serviceDto)
                ->setRequestTrnasformerTemplate($requestTransformerDto)
                ->setResponseTrnasformerTemplate($responseTransformerDto)
                ->make($dto->subFolders);
        }
    }

    private function saveTemplates()
    {
        foreach ($this->templates as $dto) {
            Saver::save($dto);
        }
    }

    private function getMigrationPath(string $migrationFilename = '', string $migrationPath = ''): string
    {
        $path = config('make_all_extended.base_path');
        if (!empty($migrationPath)) {
            $path .= $migrationPath;
        } elseif (!empty($migrationFilename)) {
            $path .= config('make_all_extended.migrations_relative_path') . $migrationFilename;
        } else {
            throw new \Exception('fill migration_filename or migration_path options');
        }

        return $path;
    }
}
