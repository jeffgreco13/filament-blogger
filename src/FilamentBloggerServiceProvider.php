<?php

namespace Jeffgreco13\FilamentBlogger;

use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;
use Jeffgreco13\FilamentBlogger\Resources\PostResource;
use Jeffgreco13\FilamentBlogger\Commands\FilamentBloggerInstall;
use Jeffgreco13\FilamentBlogger\Resources\AuthorResource;
use Jeffgreco13\FilamentBlogger\Resources\CategoryResource;

class FilamentBloggerServiceProvider extends PluginServiceProvider
{
    protected array $resources = [
        PostResource::class,
        CategoryResource::class,
        AuthorResource::class
    ];
    // protected array $pages = [
    //     //
    // ];
    // protected array $widgets = [
    //     //
    // ];
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-blogger')
            // ->hasConfigFile()
            // ->hasViews()
            ->hasMigration('create_filament_blogger_tables')
            ->hasCommand(FilamentBloggerInstall::class);
    }
}
