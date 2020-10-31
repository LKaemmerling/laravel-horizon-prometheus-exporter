<?php


namespace LKDevelopment\HorizonPrometheusExporter\Http\Controller;


use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use LKDevelopment\HorizonPrometheusExporter\Repository\ExporterRepository;
use Prometheus\RenderTextFormat;

class HorizonPrometheusExporterController extends Controller
{
    public function metrics()
    {
        ExporterRepository::load();
        $renderer = new RenderTextFormat();
        $result = $renderer->render(ExporterRepository::getRegistry()->getMetricFamilySamples());

        return new Response($result, Response::HTTP_OK, ["Content-Type" => RenderTextFormat::MIME_TYPE]);
    }
}
