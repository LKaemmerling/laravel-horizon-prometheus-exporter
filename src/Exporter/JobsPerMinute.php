<?php


namespace LKDevelopment\HorizonPrometheusExporter\Exporter;


use Laravel\Horizon\Contracts\MetricsRepository;
use LKDevelopment\HorizonPrometheusExporter\Contracts\Exporter;
use Prometheus\CollectorRegistry;

class JobsPerMinute implements Exporter
{
    protected $gauge;
    public function metrics(CollectorRegistry $prometheusExporter)
    {

        $this->gauge = $prometheusExporter->registerGauge(
            'horizon_jobs_per_minute',
            'The number of jobs per minute'
        );
    }

    public function collect()
    {
        $this->gauge->set(app(MetricsRepository::class)->jobsProcessedPerMinute());
    }
}
