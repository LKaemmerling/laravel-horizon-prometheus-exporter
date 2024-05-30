<?php


namespace LKDevelopment\HorizonPrometheusExporter\Exporter;


use Laravel\Horizon\Contracts\MasterSupervisorRepository;
use LKDevelopment\HorizonPrometheusExporter\Contracts\Exporter;
use Prometheus\CollectorRegistry;
use Prometheus\Gauge;

class HorizonStatus implements Exporter
{
    protected Gauge $gauge;

    public function metrics(CollectorRegistry $collectorRegistry): void
    {
        $this->gauge = $collectorRegistry->getOrRegisterGauge(
            config('horizon-exporter.namespace'),
            'horizon_status',
            'The status of Horizon, -1 = inactive, 0 = paused, 1 = running'
        );
    }

    public function collect(): void
    {
        $status = -1;
        if ($masters = app(MasterSupervisorRepository::class)->all()) {
            $status = collect($masters)->contains(function ($master) {
                return $master->status === 'paused';
            }) ? 0 : 1;
        }
        $this->gauge->set($status);
    }
}
