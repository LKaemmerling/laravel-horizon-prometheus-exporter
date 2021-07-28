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
        $exporters = empty($exporters) ? config('horizon-exporter.exporters') : $exporters;

        if (self::getRegistry() === null) {
            self::setRegistry(new CollectorRegistry(new InMemory()));
        }
        if (!config('horizon-exporter.parallel_exporters', false)) {
            self::collectSynchron($exporters);
            return;
        }
        self::collectAsynchron($exporters);
    }

    protected static function collectSynchron(array $exporters)
    {
        foreach ($exporters as $exporter) {
            $_exporter = new $exporter();
            /**
             * @var Exporter $_exporter
             */
            $_exporter->metrics(self::$registry);
            $_exporter->collect();
        }
    }

    protected static function collectAsynchron(array $exporters)
    {
        if (!class_exists(\Spatie\Async\Pool::class)) {
            throw new \RuntimeException("spatie/async is not installed in this project.");
        }
        $registry = self::$registry;
        $pool = \Spatie\Async\Pool::create();
        foreach ($exporters as $exporter) {
            $pool->add(function () use ($exporter, &$registry) {
                $_exporter = new $exporter();
                /**
                 * @var Exporter $_exporter
                 */
                $_exporter->metrics($registry);
                $_exporter->collect();
            });

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
