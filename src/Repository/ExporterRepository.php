<?php


namespace LKDevelopment\HorizonPrometheusExporter\Repository;


use LKDevelopment\HorizonPrometheusExporter\Contracts\Exporter;

class ExporterRepository
{
    protected static $registry;
    public static function load(){
        $exporters = config('horizon-exporter.exporters');

        self::$registry = \Prometheus\CollectorRegistry::getDefault();
        foreach ($exporters as $exporter){
            $_exporter = new $exporter();
            /**
             * @var Exporter $_exporter
             */
            $_exporter->metrics(self::$registry);
            $_exporter->collect(self::$registry);
        }
    }
    public static function getRegistry(){
        return self::$registry;
    }
}
