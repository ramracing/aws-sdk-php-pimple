<?php

namespace RamRacing\Pimple;

use InvalidArgumentException;
use PHPUnit_Framework_TestCase;
use Pimple\Container;

class AwsServiceProviderTest extends PHPUnit_Framework_TestCase
{
    protected $app;
    protected $provider;
    
    public function setUp()
    {
        $this->app = new Container();
        $this->provider = new AwsServiceProvider();
    }

    public function testRegisterProvider()
    {
        $this->app->register($this->provider, [
            'aws.config' => [
                'version' => '2006-03-01',
                'region' => 'us-east-1',
                'credentials' => [
                    'key' => 'fake-aws-key',
                    'secret' => 'fake-aws-secret',
                ]
            ]
        ]);
        $s3 = $this->app['aws']->createS3();
        
        $this->assertEquals('2006-03-01', $this->app['aws.config']['version']);
        $this->assertEquals('us-east-1', $this->app['aws.config']['region']);
        $this->assertEquals('2006-03-01', $s3->getApi()->getApiVersion());
        $this->assertEquals('us-east-1', $s3->getRegion());    
    }
    
    public function testNoConfig()
    {
        $this->app->register($this->provider, []);
        $this->setExpectedException(InvalidArgumentException::class);
        $this->app['aws']->createS3();
    }
}
