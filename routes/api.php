<?php
Route::get(config('horizon-exporter.url'), \LKDevelopment\HorizonPrometheusExporter\Http\Controller\HorizonPrometheusExporterController::class.'@metrics');

