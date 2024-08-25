# LaravelMakeAllExtended
laravel command for creating:
    model, seed, factory, repository, service, controller, formrequest,
    dto, request/response transformes based on migration

1. composer require nikitinuser/laravel-make-all-extended dev-master
2. add to app.php providers Nikitinuser\LaravelMakeAllExtended\Providers\LaravelMakeAllExtendedProvider::class,
3. php artisan vendor:publish --provider="LaravelMakeAllExtended\Providers\LaravelMakeAllExtendedProvider" 
3. php artisan make:migration table_name
4. fill migration file by your fields
5. php artisan make:all_extended
    {model_name}
    --migration_filename=2024_08_17_144345_test.php // optional if exist migration_path
    --migration_path=/database/migrations/specific/folder/2024_08_17_144345_test.php // optional if exist migration_filename
    --sub_folders=Bank\Account // optional, use if you need create sub folders and specific namespaces 
    --api=1 // default, optional, use if you need api methods in controller
    --invokable=0 // optional, use if you need invokable controller, not working if exist api option


    команды создания одиночных файлов
    рефакторинг
    документация
