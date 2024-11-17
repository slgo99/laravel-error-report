<?php

namespace Slgo99\LaravelErrorReport;

use Throwable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider as Provider;

class ServiceProvider extends Provider
{
    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/error_report.php', 'error_report');

        $this->publishes([
            __DIR__.'/config/error_report.php' => config_path('error_report.php'),
        ]);
    }

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->make('Illuminate\Contracts\Debug\ExceptionHandler')->reportable(function (Throwable $e) {
            if (config('error_report.enabled')) {
                $request = request();
                $route = "";
                $middlewares = "";
                $inputs = "";
                if ($request->route() != null) {
                    $route = "uri: " . $request->route()->getName();
                    $middlewares = json_encode($request->route()->gatherMiddleware());
                    $inputs = json_encode($request->all());
                }

                $html = $e->getMessage() . "\n\n";
                $html .= "File: " . $e->getFile() . "\n\n";
                $html .= "Line: " . $e->getLine() . "\n\n";
                $html .= "Inputs: " . $inputs . "\n\n";
                $html .= "Method: " . $request->method() . "\n\n";
                $html .= "Full URL: " . str_replace('https://', '', $request->fullUrl()) . "\n\n";
                $html .= "Route: " . $route . "\n\n";
                $html .= "Middlewares: " . $middlewares . "\n\n";
                $html .= "IP: " . $request->ip() . "\n\n";
                $html .= "User Agent: " . $request->userAgent() . "\n\n";

                if (auth()->check()) {
                    $html .= "User: " . auth()->user()->email;
                }

                Mail::raw($html, function ($message) {
                    $message->to(config('error_report.emails'))->subject("Internal Server Error");
                });
            }
        });
    }
}
