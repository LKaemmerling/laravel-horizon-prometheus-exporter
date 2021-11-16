<?php


namespace LKDevelopment\HorizonPrometheusExporter\Exporter;


use Laravel\Horizon\Contracts\MasterSupervisorRepository;
use LKDevelopment\HorizonPrometheusExporter\Contracts\Exporter;
use Prometheus\CollectorRegistry;

class CurrentMasterSupervisors implements Exporter
{
    protected $gauge;

    public function metrics(CollectorRegistry $collectorRegistry)
    {
		$this->gauge = $collectorRegistry->registerGauge(
			config('horizon-exporter.namespace'),
			'horizon_current_mastersupervisors',
			'Number of mastersupervisors'
		);
    }

    public function collect()
    {

		$number = count(app(MasterSupervisorRepository::class)->all());

		$this->gauge->set($number);
    }
}
