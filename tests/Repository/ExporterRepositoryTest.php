<?php

namespace LKDevelopment\HorizonPrometheusExporter\Tests\Repository;

use LKDevelopment\HorizonPrometheusExporter\Repository\ExporterRepository;
use LKDevelopment\HorizonPrometheusExporter\Tests\Util\NoopExporter;
use LKDevelopment\HorizonPrometheusExporter\Tests\TestCase;

class ExporterRepositoryTest extends TestCase
{

    public function testLoad()
    {
        ExporterRepository::load([NoopExporter::class]);
        self::assertNotNull(ExporterRepository::getRegistry());

        $counter = ExporterRepository::getRegistry()->getCounter("app", "noop_metric");
        self::assertNotNull($counter);
    }
}
