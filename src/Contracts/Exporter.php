<?php


namespace LKDevelopment\HorizonPrometheusExporter\Contracts;

use Prometheus\CollectorRegistry;

/**
 * Interface Exporter
 * Describes an metric exporter that generate the metrics
 * @package LKDevelopment\HorizonPrometheusExporter\Contracts
 */
interface Exporter
{
    /**
     * The metrics method is used to register/describe your metrics to the exporter.
     * @param CollectorRegistry $collectorRegistry
     * @void
     */
    public function metrics(CollectorRegistry $collectorRegistry);

    /**
     * The collect method is called from the Exporter when he collects the data.
     * You don't need to call it manually. You should perform the whole data
     * collection within this method.
     * @void
     */
    public function collect();
}
