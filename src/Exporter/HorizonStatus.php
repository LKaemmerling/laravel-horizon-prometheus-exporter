<?php


namespace LKDevelopment\HorizonPrometheusExporter\Exporter;


use Laravel\Horizon\Contracts\MasterSupervisorRepository;
use Laravel\Horizon\Contracts\MetricsRepository;
use LKDevelopment\HorizonPrometheusExporter\Contracts\Exporter;
use Prometheus\CollectorRegistry;
use Superbalist\LaravelPrometheusExporter\PrometheusExporter;

class HorizonStatus implements Exporter
{
    protected $gauge;

    public function metrics(CollectorRegistry $prometheusExporter)
    {

        $this->gauge = $prometheusExporter->registerGauge(
            config('horizon-exporter.namespace'),
            'horizon_status',
            'The status of Horizon, -1 = inactive, 0 = paused, 1 = running'
        );
    }

    public function collect()
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
