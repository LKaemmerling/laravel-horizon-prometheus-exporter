<?php
return [
    "namespace" => 'app',
    "enabled" => env('HORIZON_PROMETHEUS_EXPORTER_ENABLED', true),

    /**
     * You can change the default endpoint to something other than metrics.
     * Keep in mind that the change needs to be reflected in your Prometheus configuration as well.
     */
    "url" => 'metrics',

    /**
     * You can enable or disable or even create own exporters by simply implementing the LKDevelopment\HorizonPrometheusExporter\Contracts\Exporter Contract.
     * If you want to disable oder enable a Exporter just comment the specific line out.
     * If you want to add your own Exporter just add the Class Name to this array
     */
    "exporters" => [
        \LKDevelopment\HorizonPrometheusExporter\Exporter\CurrentMasterSupervisors::class,
        \LKDevelopment\HorizonPrometheusExporter\Exporter\JobsPerMinute::class,
        \LKDevelopment\HorizonPrometheusExporter\Exporter\CurrentWorkload::class,
        \LKDevelopment\HorizonPrometheusExporter\Exporter\CurrentProccesesPerQueue::class,
        \LKDevelopment\HorizonPrometheusExporter\Exporter\FailedJobsPerHour::class,
        \LKDevelopment\HorizonPrometheusExporter\Exporter\HorizonStatus::class,
        \LKDevelopment\HorizonPrometheusExporter\Exporter\RecentJobs::class
    ],

    /**
     * IP Whitelisting, you may don't want to expose your metrics on the internet so you can add the IP addresses of your Prometheus Server here.
     */
    "ip_whitelist" => [
        // Keep empty to allow all IP addresses
    ],

    /**
     * You can change the Middleware which is used for the IP whitelisting.  You can add your own, like a token based authentication.
     */
    "middleware" => \LKDevelopment\HorizonPrometheusExporter\Http\Middleware\IPWhitelistingMiddleware::class,

    /**
     * Allow storage to be wiped after a render of data in metrics controller
     */
    "wipe_storage_after_render" => false,
];
