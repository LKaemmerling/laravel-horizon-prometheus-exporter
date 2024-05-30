<?php


namespace LKDevelopment\HorizonPrometheusExporter\Exporter;


use Laravel\Horizon\Contracts\MasterSupervisorRepository;
use LKDevelopment\HorizonPrometheusExporter\Contracts\Exporter;
use Prometheus\CollectorRegistry;
use Prometheus\Gauge;

class CurrentMasterSupervisors implements Exporter
{
    protected Gauge $gauge;

    public function metrics(CollectorRegistry $collectorRegistry): void
    {
		$this->gauge = $collectorRegistry->getOrRegisterGauge(
			config('horizon-exporter.namespace'),
			'horizon_current_mastersupervisors',
			'Number of mastersupervisors'
		);
    }

    public function collect(): void
    {
		$number = count(app(MasterSupervisorRepository::class)->all());

		$this->gauge->set($number);
    }
}
