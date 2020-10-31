# Laravel Horizon Prometheus Exporter

[![Latest Version on Packagist](https://img.shields.io/packagist/v/lkaemmerling/laravel-horizon-prometheus-exporter.svg?style=flat-square)](https://packagist.org/packages/lkaemmerling/laravel-horizon-prometheus-exporter)
[![Actions Status](https://github.com/lkaemmerling/laravel-horizon-prometheus-exporter/workflows/Tests/badge.svg)](https://github.com/lkaemmerling/laravel-horizon-prometheus-exporter/actions)
[![Total Downloads](https://img.shields.io/packagist/dt/lkaemmerling/laravel-horizon-prometheus-exporter.svg?style=flat-square)](https://packagist.org/packages/lkaemmerling/laravel-horizon-prometheus-exporter)


This package allows an easy way to expose the Laravel Horizon Metrics to Prometheus.

## Prom... What?

Prometheus is a scraping service which allows you to easily store and scrape information from your application, server or even from your router!
Prometheus itself does not know about your application, so you need a exporter on your app. This small package is exactly this, an exporter which allows Prometheus to understand some information
from your application. With Prometheus and a visualisation tool called `Grafana` you can build something like this beautiful Dashboard:

![Laravel Horizon Prometheus Exporter Dashboard](https://pbs.twimg.com/media/EHdSoNGX4AEpbia?format=jpg&name=4096x4096)

## Installation

You can install the package via composer:

```bash
composer require lkaemmerling/laravel-horizon-prometheus-exporter
```

## Configuration
```bash
php artisan vendor:publish --provider=LKDevelopment\\HorizonPrometheusExporter\\HorizonPrometheusExporterServiceProvider
```
You can configure this package by changing the values in `config/horizon-exporter.php`.

## Custom Metrics

You can also use this package easily to expose custom metrics. You just need to implement the `LKDevelopment\HorizonPrometheusExporter\Contracts\Exporter` interface and then add your implementation to your `config/horizon-exporter.php` like we do it for the Horizon exporters: https://github.com/LKaemmerling/laravel-horizon-prometheus-exporter/blob/master/config/config.php#L17

## Dashboard

You can find a sample dashboard using this metrics on the [Grafana Marketplace](https://grafana.com/grafana/dashboards/11034).

### Testing

``` bash
composer test
```

### Changelog

Please see [Releases](https://github.com/LKaemmerling/laravel-horizon-prometheus-exporter/releases) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email kontakt@lukas-kaemmerling.de instead of using the issue tracker.

## Credits

- [Lukas Kämmerling](https://github.com/LKaemmerling)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
