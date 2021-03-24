<?php


namespace LKDevelopment\HorizonPrometheusExporter\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\IpUtils;

class IPWhitelistingMiddleware
{
    public function handle(Request $request, \Closure $next)
    {
        if (!empty(config('horizon-exporter.ip_whitelist'))) {
            $clientIp = $request->ip();
            if (IpUtils::checkIp($clientIp, config('horizon-exporter.ip_whitelist'))) {
                return $next($request);
            } else {
                abort(403);
            }
        } else {
            return $next($request);
        }
    }
}
