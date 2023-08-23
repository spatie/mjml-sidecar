<?php

namespace Spatie\MjmlSidecar;

use Hammerstone\Sidecar\LambdaFunction;
use Hammerstone\Sidecar\Package;
use Hammerstone\Sidecar\Runtime;

class MjmlFunction extends LambdaFunction
{
    public function handler(): string
    {
        return 'sidecar.handle';
    }

    public function name(): string
    {
        return 'Mjml';
    }

    public function package(): Package
    {
        return Package::make()
            ->setBasePath(__DIR__.'/../lambda')
            ->include('*');
    }

    public function runtime(): string
    {
        return Runtime::NODEJS_16;
    }
}
