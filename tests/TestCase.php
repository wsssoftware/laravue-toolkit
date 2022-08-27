<?php

namespace Laravue\LaravueToolkit\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Laravue\LaravueToolkit\LaravueToolkitServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Laravue\\LaravueToolkit\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravueToolkitServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_laravue-toolkit_table.php.stub';
        $migration->up();
        */
    }
}
