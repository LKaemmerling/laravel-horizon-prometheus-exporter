<?php


namespace LKDevelopment\HorizonPrometheusExporter\Contracts;

use Prometheus\CollectorRegistry;

interface Exporter
{
    public function metrics(CollectorRegistry $prometheusExporter);
    public function collect();
}
