<?php


namespace LKDevelopment\HorizonPrometheusExporter\Http\Controller;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use LKDevelopment\HorizonPrometheusExporter\Contracts\Exporter;
use LKDevelopment\HorizonPrometheusExporter\Repository\ExporterRepository;
use Prometheus\RenderTextFormat;

class HorizonPrometheusExporterController extends Controller
{
    public function metrics()
    {
        ExporterRepository::load();
        $renderer = new RenderTextFormat();
        $result = $renderer->render(ExporterRepository::getRegistry()->getMetricFamilySamples());

        return Response::create($result, Response::HTTP_OK, ["Content-Type" => RenderTextFormat::MIME_TYPE]);
    }
}
