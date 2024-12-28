<?php


namespace LKDevelopment\HorizonPrometheusExporter\Exporter;


use Laravel\Horizon\Contracts\WorkloadRepository;
use LKDevelopment\HorizonPrometheusExporter\Contracts\Exporter;
use Prometheus\CollectorRegistry;
use Prometheus\Gauge;

class CurrentWorkload implements Exporter
{
    protected Gauge $gauge;

    public function metrics(CollectorRegistry $collectorRegistry): void
    {
        $this->gauge = $collectorRegistry->getOrRegisterGauge(
            config('horizon-exporter.namespace'),
            'horizon_current_workload',
            'Current workload of all queues',
            ['queue']
        );
    }

    public function collect(): void
    {
        $workloadRepository = app(WorkloadRepository::class);
        $workloads = collect($workloadRepository->get())->sortBy('name')->values();

        $workloads->each(function ($workload) {
            if (isset($workload['split_queues']) && $workload['split_queues']) {
                $workload['split_queues']->each(function ($queue) {
                    $this->gauge->set($queue['length'], [$queue['name']]);
                });

                return;
            }

            $this->gauge->set($workload['length'], [$workload['name']]);
        });
    }
}
