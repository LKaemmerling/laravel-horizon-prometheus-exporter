<?php


namespace LKDevelopment\HorizonPrometheusExporter\Repository;


use LKDevelopment\HorizonPrometheusExporter\Contracts\Exporter;
use Prometheus\CollectorRegistry;
use Prometheus\Storage\InMemory;

/**
 * Class ExporterRepository
 * @package LKDevelopment\HorizonPrometheusExporter\Repository
 */
class ExporterRepository
{
    /**
     * @var CollectorRegistry
     */
    protected static $registry;

    /**
     * @param array $exporters
     */
    public static function load(array $exporters = []): void
    {
        $_exporters = empty($exporters) ? config('horizon-exporter.exporters') : $exporters;

        if (self::getRegistry() === null) {
            self::setRegistry(new CollectorRegistry(new InMemory()));
        }
        foreach ($_exporters as $exporter) {
            $_exporter = new $exporter();
            /**
             * @var Exporter $_exporter
             */
            $_exporter->metrics(self::$registry);
            $_exporter->collect();
        }
    }

    /**
     * @param CollectorRegistry $collectorRegistry
     */
    public static function setRegistry(CollectorRegistry $collectorRegistry)
    {
        self::$registry = $collectorRegistry;
    }

    /**
     * @return CollectorRegistry
     */
    public static function getRegistry()
    {
        return self::$registry;
    }
}
