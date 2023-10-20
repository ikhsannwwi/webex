<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TrackStatistics
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $statistics = new \App\Models\Admin\Statistic;
        $statistics->ip_address = $request->ip();

        $agent = new \Jenssegers\Agent\Agent;
        $statistics->device = $agent->device();
        $statistics->platform = $agent->platform();
        $statistics->browser = $agent->browser();
        $statistics->visit_time = now();
        $statistics->save();

        return $next($request);
    }
}
