<?php


namespace LKDevelopment\HorizonPrometheusExporter\Exporter;


use Laravel\Horizon\Contracts\JobRepository;
use LKDevelopment\HorizonPrometheusExporter\Contracts\Exporter;
use Prometheus\CollectorRegistry;

class FailedJobsPerHour implements Exporter
{
    protected $gauge;

    public function metrics(CollectorRegistry $collectorRegistry)
    {
        $this->gauge = $collectorRegistry->registerGauge(
            config('horizon-exporter.namespace'),
            'horizon_failed_jobs',
            'The number of recently failed jobs'
        );
    }

    public function collect()
    {
        $this->gauge->set(app(JobRepository::class)->countRecentlyFailed());
    }
}
