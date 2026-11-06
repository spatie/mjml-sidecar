<?php

namespace Spatie\MjmlSidecar\Tests;

use Aws\CommandInterface;
use Aws\Result;
use GuzzleHttp\Promise\Create;
use GuzzleHttp\Promise\PromiseInterface;
use Hammerstone\Sidecar\Clients\LambdaClient;
use Hammerstone\Sidecar\Providers\SidecarServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use LogicException;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\MjmlSidecar\MjmlFunction;
use Symfony\Component\Process\Process;

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
        config()->set('sidecar.functions', [MjmlFunction::class]);
        config()->set('sidecar.env', 'testing');

        $app->instance(LambdaClient::class, new LambdaClient([
            'version' => 'latest',
            'region' => 'eu-central-1',
            'credentials' => ['key' => 'local-only', 'secret' => 'local-only'],
            'handler' => function (CommandInterface $command): PromiseInterface {
                if ($command->getName() !== 'Invoke') {
                    throw new LogicException('Only local Lambda invocations are allowed in tests.');
                }

                $process = new Process(['node', __DIR__.'/invoke.mjs']);
                $process->setInput($command['Payload']);
                $process->mustRun();

                return Create::promiseFor(new Result([
                    'StatusCode' => 200,
                    'Payload' => $process->getOutput(),
                    'LogResult' => '',
                ]));
            },
        ]));
    }
}
