# LaravelMakeAllExtended
laravel command for creating model, repository, service, controller, formrequest, api based on migration

1. composer require nikitinuser/laravel-make-all-extended dev-master
2. php artisan make:migration table_name
3. fill migration file by your fields
4. php artisan make:all_extended -migration=migration_name -model_name=NameModel
    or
    php artisan make:all_extended -migration_path=migration_path -model_name=NameModel
    -api
    -invokable
