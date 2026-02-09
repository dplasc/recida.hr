<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\AnyAuthMiddleware;
use App\Http\Middleware\IsCustomer;
use App\Http\Middleware\IsAgent;
use App\Http\Middleware\CheckDatabaseConnection;
use App\Http\Middleware\PreventBackHistory;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: __DIR__.'/../routes/console.php',
        using: function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
     
            Route::middleware(['web','PreventBackHistory'])
                ->group(base_path('routes/web.php'));

            Route::middleware(['web','PreventBackHistory'])
                ->group(base_path('routes/customer.php'));
            Route::middleware(['web','PreventBackHistory'])
                ->group(base_path('routes/agent.php'));
            Route::middleware(['web','PreventBackHistory'])
                ->group(base_path('routes/payment.php'));
            if (addon_status('live_chat') == 1){
                Route::middleware(['web','PreventBackHistory'])
                ->group(base_path('routes/live_chat.php'));
            }
            if (addon_status('shop') == 1){
                Route::middleware(['web','PreventBackHistory'])
                ->group(base_path('routes/shop.php'));
            }
            if (addon_status('form_builder') == 1){
                Route::middleware(['web','PreventBackHistory'])
                ->group(base_path('routes/form_builder.php'));
            }
            Route::middleware(['web','PreventBackHistory'])
            ->group(base_path('routes/custom_field.php'));

              if (addon_status('service_selling') == 1){
                Route::middleware(['web','PreventBackHistory'])
                ->group(base_path('routes/service_selling.php'));
             }
             if (addon_status('calendly') == 1){
                Route::middleware(['web','PreventBackHistory'])
                ->group(base_path('routes/calendly.php'));
             }
         
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => AdminMiddleware::class,
            'customer' => IsCustomer::class,
            'agent' => IsAgent::class,
            'anyAuth' => AnyAuthMiddleware::class,
            'CheckDatabaseConnection' => CheckDatabaseConnection::class,
            'PreventBackHistory' => PreventBackHistory::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
