<?php

namespace LKDevelopment\HorizonPrometheusExporter\Tests\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use LKDevelopment\HorizonPrometheusExporter\Http\Middleware\IPWhitelistingMiddleware;
use LKDevelopment\HorizonPrometheusExporter\Tests\TestCase;
use Symfony\Component\HttpKernel\Exception\HttpException;

class IPWhitelistingMiddlewareTest extends TestCase
{
    /**
     * @dataProvider testCases
     */
    public function testHandle($requestingIP, $expectedStatusCode)
    {
        $middleware = new IPWhitelistingMiddleware();
        $statusCode = null;
        try {
            $statusCode = $middleware->handle(new Request([], [], [], [], [], ['REMOTE_ADDR' => $requestingIP]), \Closure::fromCallable(function ($next) {
                return new Response();
            }))->getStatusCode();

        } catch (HttpException $httpException) {
            $statusCode = $httpException->getStatusCode();
        }
        self::assertEquals($expectedStatusCode, $statusCode);
    }

    public function testCases()
    {
        return [
            [
                "127.0.0.1", // Requesting IP
                Response::HTTP_OK // Expected Status Code
            ],
            [
                "127.0.0.2",
                Response::HTTP_FORBIDDEN
            ],
            [
                "10.0.0.1",
                Response::HTTP_OK
            ],
            [
                "10.0.1.1",
                Response::HTTP_FORBIDDEN
            ]
        ];
    }
}
