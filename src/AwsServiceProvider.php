<?php

namespace RamRacing\Pimple;

use Aws\Sdk;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class AwsServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['aws'] = function (Container $app) {
            $config = isset($app['aws.config']) ? $app['aws.config'] : [];
            return new Sdk($config);
        };
    }
}
