<?php


namespace LKDevelopment\HorizonPrometheusExporter\Exporter;


use Laravel\Horizon\Contracts\JobRepository;
use LKDevelopment\HorizonPrometheusExporter\Contracts\Exporter;
use Prometheus\CollectorRegistry;
use Prometheus\Gauge;

class FailedJobsPerHour implements Exporter
{
    protected Gauge $gauge;

    public function metrics(CollectorRegistry $collectorRegistry): void
    {
        $this->gauge = $collectorRegistry->getOrRegisterGauge(
            config('horizon-exporter.namespace'),
            'horizon_failed_jobs',
            'The number of recently failed jobs'
        );
    }

    public function collect(): void
    {
        $this->gauge->set(app(JobRepository::class)->countRecentlyFailed());
    }
}
