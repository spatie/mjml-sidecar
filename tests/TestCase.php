<?php

namespace Spatie\MjmlSidecar\Tests;

use Hammerstone\Sidecar\Deployment;
use Hammerstone\Sidecar\Providers\SidecarServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\Bootstrap\LoadEnvironmentVariables;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\Mjml\Functions\MjmlFunction;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Spatie\\MjmlSidecar\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            SidecarServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app->useEnvironmentPath(__DIR__.'/..');
        $app->bootstrapWith([LoadEnvironmentVariables::class]);

        config()->set('sidecar.functions', [MjmlFunction::class]);
        config()->set('sidecar.env', 'testing');
        config()->set('sidecar.aws_key', env('SIDECAR_ACCESS_KEY_ID'));
        config()->set('sidecar.aws_secret', env('SIDECAR_SECRET_ACCESS_KEY'));
        config()->set('sidecar.aws_region', 'eu-central-1');
        config()->set('sidecar.aws_bucket', 'sidecar-mjml');
        config()->set('sidecar.execution_role', env('SIDECAR_EXECUTION_ROLE'));

        Deployment::make()->deploy()->activate();
    }
}
