<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth as Auth;
use App\Models\LogRequest as LogRequest;

class LogRoute
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (app()->environment('local')) {
            $log_request = new LogRequest;
            $log_request->auth_user = Auth::user();
            $log_request->uri = $request->getUri();
            $log_request->method = $request->getMethod();
            $log_request->request_body = $request->getContent();
            $log_request->response_body = $response->getContent();
            $log_request->response_status = $response->status();
            $log_request->request_ip = $request->ip();
            $log_request->save();
        }

        return $response;
    }
}
