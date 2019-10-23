<?php
Route::group(['middleware' => config('horizon-exporter.middleware')], function(){
    Route::get(config('horizon-exporter.url'), \LKDevelopment\HorizonPrometheusExporter\Http\Controller\HorizonPrometheusExporterController::class.'@metrics');
});
