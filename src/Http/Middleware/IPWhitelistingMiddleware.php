<?php


namespace LKDevelopment\HorizonPrometheusExporter\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class IPWhitelistingMiddleware
{
    public function handle(Request $request, \Closure $next): Response
    {
        if (!empty(config('horizon-exporter.ip_whitelist'))) {
            $clientIp = $request->ip();
            if (in_array($clientIp, config('horizon-exporter.ip_whitelist'))) {
                return $next($request);
            } else {
                abort(403);
            }
        } else {
            return $next($request);
        }
    }
}
