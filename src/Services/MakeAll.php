<?php

namespace Nikitinuser\LaravelMakeAllExtended\Services;

use Nikitinuser\LaravelMakeAllExtended\Dto\MakeAllDto;
use Nikitinuser\LaravelMakeAllExtended\Services\MakeApiController;
use Nikitinuser\LaravelMakeAllExtended\Services\MakeDto;
use Nikitinuser\LaravelMakeAllExtended\Services\MakeFactory;
use Nikitinuser\LaravelMakeAllExtended\Services\MakeInvokableController;
use Nikitinuser\LaravelMakeAllExtended\Services\MakeFormRequest;
use Nikitinuser\LaravelMakeAllExtended\Services\MakeModel;
use Nikitinuser\LaravelMakeAllExtended\Services\MakeRepository;
use Nikitinuser\LaravelMakeAllExtended\Services\MakeRequestTransformer;
use Nikitinuser\LaravelMakeAllExtended\Services\MakeResponseTransformer;
use Nikitinuser\LaravelMakeAllExtended\Services\MakeSeed;
use Nikitinuser\LaravelMakeAllExtended\Services\MakeService;
use Nikitinuser\LaravelMakeAllExtended\Services\Parser;

class MakeAll
{
    public function __construct(
        private MakeApiController $makeApiController,
        private MakeDto $makeDto,
        private MakeFactory $makeFactory,
        private MakeInvokableController $makeInvokableController,
        private MakeFormRequest $makeFormRequest,
        private MakeModel $makeModel,
        private MakeRepository $makeRepository,
        private MakeRequestTransformer $makeRequestTransformer,
        private MakeResponseTransformer $makeResponseTransformer,
        private MakeSeed $makeSeed,
        private MakeService $makeService,
        private Parser $parser,
    ) {
    }

    public function __invoke(MakeAllDto $dto)
    {
        $path = $this->getMigrationPath($dto->migrationFilename, $dto->migrationPath);

        $columns = ($this->parser)($path);

        $modelInfo = ($this->makeModel)($dto->modelName, $columns, $dto->subFolders);
        $factoryInfo = ($this->makeFactory)($dto->modelName, $modelInfo['namespace']);
        $seedInfo = ($this->makeSeed)($dto->modelName, $modelInfo['namespace']);
        $repoInfo = ($this->makeRepository)($dto->modelName, $modelInfo['namespace'], $dto->subFolders);

        $dtoInfo = ($this->makeDto)($dto->modelName, $columns, $dto->subFolders);
        $requestTransformerInfo = ($this->makeRequestTransformer)(
            $dto->modelName,
            $dtoInfo['namespace'],
            $dtoInfo['className'],
            $dto->subFolders
        );
        $responseTransformerInfo = ($this->makeResponseTransformer)(
            $dto->modelName,
            $dtoInfo['namespace'],
            $dtoInfo['className'],
            $dto->subFolders
        );

        $serviceInfo = ($this->makeService)($dto->modelName, $repoInfo['namespace'], $repoInfo['className'], $dto->subFolders);

        $formrequestInfo = ($this->makeFormRequest)($dto->modelName, $dto->subFolders);

        if (!empty($dto->api)) {
            $controllerInfo = ($this->makeApiController)($dto->modelName, $dto->subFolders);

            if (!empty($dto->route)) {
                // Todo
            }
        } elseif (!empty($dto->invokable)) {
            $controllerInfo = ($this->makeInvokableController)($dto->modelName, $dto->subFolders);
        }
    }

    private function getMigrationPath(string $migrationFilename = '', string $migrationPath = ''): string
    {
        $path = base_path();
        if (!empty($migrationPath)) {
            $path .= $migrationPath;
        } elseif (!empty($migrationFilename)) {
            $path .= "/database/migrations/" . $migrationFilename;
        } else {
            throw new \Exception('fill migration_filename or migration_path options');
        }

        return $path;
    }
}
