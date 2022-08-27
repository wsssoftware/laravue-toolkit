<?php

namespace Laravue\LaravueToolkit;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Laravue\LaravueToolkit\Commands\LaravueToolkitCommand;

class LaravueToolkitServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravue-toolkit')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravue-toolkit_table')
            ->hasCommand(LaravueToolkitCommand::class);
    }
}
