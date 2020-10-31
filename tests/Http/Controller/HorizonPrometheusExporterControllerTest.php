<?php

namespace LKDevelopment\HorizonPrometheusExporter\Tests\Http\Controller;

use LKDevelopment\HorizonPrometheusExporter\Http\Controller\HorizonPrometheusExporterController;
use LKDevelopment\HorizonPrometheusExporter\Repository\ExporterRepository;
use LKDevelopment\HorizonPrometheusExporter\Tests\Util\NoopExporter;
use LKDevelopment\HorizonPrometheusExporter\Tests\TestCase;

class HorizonPrometheusExporterControllerTest extends TestCase
{

    public function testMetrics()
    {
        $ctrl = new HorizonPrometheusExporterController();

        $resp = $ctrl->metrics();
        $expected = <<<EOF
# HELP app_noop_metric noop metric
# TYPE app_noop_metric counter
app_noop_metric{op="noop"} 1
EOF;
        self::assertStringContainsString($expected, $resp);

    }
}
