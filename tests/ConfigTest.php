<?php

namespace Helsinque\Tests;

use Helsinque\Config;

class ConfigTest extends \PHPUnit_Framework_TestCase
{
    public function assertPreConditions()
    {
        $this->assertTrue(
                class_exists($class = '\Helsinque\Config'),
                'Class not found: '.$class
        );
    }

    public function testLoadAndGetFunction()
    {
        $array = [
            'ENV_EXAMPLE' => 'localhost'
        ];

        Config::load($array);

        $this->assertEquals('localhost', Config::get('ENV_EXAMPLE'));
    }

    public function testsetAdnGetFunction()
    {
        $array = [
            'ENV_EXAMPLE' => 'localhost'
        ];

        Config::set('ENV_EXAMPLE2', 'localhost');

        $this->assertEquals('localhost', Config::get('ENV_EXAMPLE2'));
    }
    
}