<?php


namespace LKDevelopment\HorizonPrometheusExporter\Exporter;


use Laravel\Horizon\Contracts\WorkloadRepository;
use LKDevelopment\HorizonPrometheusExporter\Contracts\Exporter;
use Prometheus\CollectorRegistry;

class CurrentWorkload implements Exporter
{
    protected $gauge;
    public function metrics(CollectorRegistry $collectorRegistry)
    {
        $this->gauge = $collectorRegistry->registerGauge(
            config('horizon-exporter.namespace'),
            'horizon_current_workload',
            'Current workload of all queues',
            ['queue']
        );
    }

    public function collect()
    {
        $workloadRepository = app(WorkloadRepository::class);
        $workloads = collect($workloadRepository->get())->sortBy('name')->values();

        $workloads->each(function ($workload) {
            $this->gauge->set($workload['length'], [$workload['name']]);
        });
    }
}
