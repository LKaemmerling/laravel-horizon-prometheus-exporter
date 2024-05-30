<?php


namespace LKDevelopment\HorizonPrometheusExporter\Exporter;

use Laravel\Horizon\Contracts\WorkloadRepository;
use LKDevelopment\HorizonPrometheusExporter\Contracts\Exporter;
use Prometheus\CollectorRegistry;
use Prometheus\Gauge;

class CurrentProcessesPerQueue implements Exporter
{
    protected Gauge $gauge;

    public function metrics(CollectorRegistry $collectorRegistry): void
    {
        $this->gauge = $collectorRegistry->getOrRegisterGauge(
            config('horizon-exporter.namespace'),
            'horizon_current_processes',
            'Current processes of all queues',
            ['queue']
        );
    }

    public function collect(): void
    {
        $workloadRepository = app(WorkloadRepository::class);
        $workloads = collect($workloadRepository->get())->sortBy('name')->values();

        $workloads->each(function ($workload) {
            $this->gauge->set($workload['processes'], [$workload['name']]);
        });
    }
}
