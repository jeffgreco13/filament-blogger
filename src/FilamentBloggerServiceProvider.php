<?php

namespace Jeffgreco13\FilamentBlogger;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Jeffgreco13\FilamentBlogger\Commands\FilamentBloggerCommand;

class FilamentBloggerServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('filament-blogger')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_filament-blogger_table')
            ->hasCommand(FilamentBloggerCommand::class);
    }
}
