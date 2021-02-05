<?php
namespace LKDevelopment\HorizonPrometheusExporter\Tests;

use LKDevelopment\HorizonPrometheusExporter\Tests\Util\NoopExporter;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('horizon-exporter.exporters', [NoopExporter::class]);
        $app['config']->set('horizon-exporter.ip_whitelist', ["127.0.0.1", "10.0.0.0/24"]);
    }
}
