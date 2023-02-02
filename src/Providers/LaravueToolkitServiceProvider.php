<?php

namespace Laravue\Providers;

use Illuminate\Session\SessionManager;
use Laravue\Flash\Flash;
use Laravue\Utility\File;
use const DIRECTORY_SEPARATOR;
use Illuminate\Foundation\Application;
use Laravue\Commands\Deploy\ComposerUpdateCommand;
use Laravue\Commands\Deploy\GitPullCommand;
use Laravue\Commands\Deploy\NpmUpdateCommand;
use Laravue\Commands\Deploy\ViteBuildCommand;
use Laravue\Commands\LaravueToolkitCommand;
use Laravue\Enums\CurrencyFormat;
use Laravue\Utility\CrawlerDetector\CrawlerDetector;
use Laravue\Utility\Documents\CNPJ;
use Laravue\Utility\Documents\CPF;
use Laravue\Utility\Enum;
use Laravue\Utility\Number;
use Laravue\Utility\ServerInfo;
use Laravue\Utility\Text;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravueToolkitServiceProvider extends PackageServiceProvider
{
    /**
     * @param  \Spatie\LaravelPackageTools\Package  $package
     * @return void
     */
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
            ->hasCommands([
                LaravueToolkitCommand::class,
            ]);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(Flash::class, function (Application $app) {
            return new Flash($app->make(SessionManager::class));
        });
        $this->app->bind(CrawlerDetector::class, function (Application $app) {
            return new CrawlerDetector(request());
        });
        $this->app->bind(CPF::class, function (Application $app) {
            return new CPF();
        });
        $this->app->bind(CNPJ::class, function (Application $app) {
            return new CNPJ();
        });
        $this->app->bind(Enum::class, function (Application $app) {
            return new Enum();
        });
        $this->app->bind(Flash::class, function (Application $app) {
            return $app->make(Flash::class);
        });
        $this->app->bind(File::class, function (Application $app) {
            return new File();
        });
        $this->app->bind(Number::class, function (Application $app) {
            return new Number($app->currentLocale(), CurrencyFormat::DEFAULT, 'BRL');
        });
        $this->app->bind(ServerInfo::class, function (Application $app) {
            return new ServerInfo();
        });
        $this->app->bind(Text::class, function (Application $app) {
            return new Text();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        $langPath = dirname(__DIR__, 2).DIRECTORY_SEPARATOR.'lang';
        $this->loadTranslationsFrom($langPath, 'laravue');

        $this->publishes([
            $langPath => $this->app->langPath('vendor/laravue'),
        ], 'laravue-toolkit-lang');

        $this->commands([
            LaravueToolkitCommand::class,
            ComposerUpdateCommand::class,
            GitPullCommand::class,
            NpmUpdateCommand::class,
            ViteBuildCommand::class,
        ]);
    }
}
