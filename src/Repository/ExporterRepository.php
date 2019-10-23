<?php


namespace LKDevelopment\HorizonPrometheusExporter\Repository;


use LKDevelopment\HorizonPrometheusExporter\Contracts\Exporter;
use Prometheus\CollectorRegistry;
use Prometheus\Storage\InMemory;

class ExporterRepository
{
    protected static $registry;
    public static function load(){
        $exporters = config('horizon-exporter.exporters');

        self::$registry = new CollectorRegistry(new InMemory());
        foreach ($exporters as $exporter){
            $_exporter = new $exporter();
            /**
             * @var Exporter $_exporter
             */
            $_exporter->metrics(self::$registry);
            $_exporter->collect();
        }
    }
    public static function getRegistry(){
        return self::$registry;
    }
}
