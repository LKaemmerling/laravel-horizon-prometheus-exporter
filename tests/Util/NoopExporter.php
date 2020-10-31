<?php


namespace LKDevelopment\HorizonPrometheusExporter\Tests\Util;


use Prometheus\CollectorRegistry;
use Prometheus\Counter;

/**
 * Class NoopExporter
 * @package LKDevelopment\HorizonPrometheusExporter\Tests\Util
 */
class NoopExporter implements \LKDevelopment\HorizonPrometheusExporter\Contracts\Exporter
{
    /**
     * @var Counter
     */
    protected $counter;
    /**
     * @inheritDoc
     */
    public function metrics(CollectorRegistry $collectorRegistry)
    {
        $this->counter = $collectorRegistry->getOrRegisterCounter(
            "app",
            'noop_metric',
            'noop metric',
            ["op"]
        );
    }

    /**
     * @inheritDoc
     */
    public function collect()
    {
        $this->counter->inc(["op" => "noop"]);
    }
}
