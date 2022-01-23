<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        //\App\Http\Middleware\LanguageSwicher::class,

      ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            //\App\Http\Middleware\ViewFilter::class,
            //\App\Http\Middleware\HasAccessMiddleware::class,
            \App\Http\Middleware\LanguageSwicher::class,

        ],

        'api' => [
            'throttle:60,1',
            'bindings',
             \App\Http\Middleware\APILangMiddleware::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'LanguageSwicher' => \App\Http\Middleware\LanguageSwicher::class,
        'access'=>\App\Http\Middleware\HasAccessMiddleware::class,
        'ViewFilter'=>\App\Http\Middleware\ViewFilter::class,
        'AccessDashboard'=>\App\Http\Middleware\AccessDashboard::class,
        'AllowSetting'=>\App\Http\Middleware\SettingMiddleware::class,
        'Api'=>\App\Http\Middleware\APIKeyMiddleware::class,
        'authapi'=>\App\Http\Middleware\AuthApiMiddleware::class,
        'activeapi'=>\App\Http\Middleware\ActivatedMiddleware::class,
        'verifiedapi'=>\App\Http\Middleware\VerifiedMiddleware::class,


    ];
}
