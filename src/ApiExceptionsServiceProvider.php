<?php

declare(strict_types=1);

namespace JCCoca\ApiExceptions;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Http\Kernel;
use JCCoca\ApiExceptions\Http\Middleware\ForceJsonResponse;

class ApiExceptionsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/api-exceptions.php', 'api-exceptions'
        );
    }

    public function boot(Kernel $kernel): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/api-exceptions.php' => config_path('api-exceptions.php'),
            ], 'api-exceptions-config');
        }

        if (config('api-exceptions.force_json', true)) {
            $router = $this->app['router'];
            $router->prependMiddlewareToGroup('api', ForceJsonResponse::class);
        }
    }
}