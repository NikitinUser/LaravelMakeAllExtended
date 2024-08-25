# LaravelMakeAllExtended
laravel command for creating:
    model, seed, factory, repository, service, controller, formrequest,
    dto, request/response transformes based on migration

## Installation

```
composer require nikitinuser/laravel-make-all-extended
```

add to app.php providers Nikitinuser\LaravelMakeAllExtended\Providers\LaravelMakeAllExtendedProvider::class,

```
php artisan vendor:publish --provider="LaravelMakeAllExtended\Providers\LaravelMakeAllExtendedProvider"
```

## Usage
1. make your migration
```
php artisan make:migration table_name
```

2. fill migration file by your fields
3. run php artisan make:all_extended
    {model_name}
    --migration_filename=2024_08_17_144345_test.php // optional if exist migration_path
    --migration_path=/database/migrations/specific/folder/2024_08_17_144345_test.php // optional if exist migration_filename
    --sub_folders=Bank\Account // optional, use if you need create sub folders and specific namespaces 
    --api=0 // optional, use if you need api methods in controller
    --invokable=0 // optional, use if you need invokable controller, not working if exist api option

### Make all by migration name, without sub folders, without controller
```
php artisan make:all_extended Test --migration_filename=2024_08_17_144345_test.php
```
this created model, seed, factory, repository, service, dto

### Make all by migration name, with sub folders, without controller
```
php artisan make:all_extended Test --sub_folders=Bank\Account --migration_filename=2024_08_17_144345_test.php
```
this created model, seed, factory, repository, service, dto

### Make all by migration path
```
php artisan make:all_extended Test --migration_path=/database/migrations/specific/folder/2024_08_17_144345_test.php
```
this created model, seed, factory, repository, service, dto

### Make all by migration name, with api controller
```
php artisan make:all_extended Test --migration_filename=2024_08_17_144345_test.php --api=1
```
this created model, seed, factory, repository, service, dto, controller, form requests for creating and updating, request and response transformers

### Make all by migration name, with invokable controller
```
php artisan make:all_extended Test --migration_filename=2024_08_17_144345_test.php --invokable=1
```
this created model, seed, factory, repository, service, dto, controller, request and response transformers


### sub_folders
option sub_folders created folders and extend namespaces for classes
for example
```
php artisan make:all_extended Test --sub_folders=Bank\Account --migration_filename=2024_08_17_144345_test.php
```
this create model in folder app\Models\Bank\Account with namespace App\Models\Bank\Account etc.

option not work with seeders and factories, they are always created in the default folder
