<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Tymon\JWTAuth\Http\Middleware\Authenticate as JwtAuthenticate;

class Kernel extends HttpKernel
{
    /**
     * ➊  Middleware global (mantenha o que precisar)
     */
    protected array $middleware = [
        // \App\Http\Middleware\TrustProxies::class,
        // \Illuminate\Http\Middleware\HandleCors::class,
        // \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        // \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        // \App\Http\Middleware\TrimStrings::class,
        // \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * ➋  Grupos – coloque o auth:api aqui se quiser proteger TODAS rotas api
     */
    protected array $middlewareGroups = [
        'web' => [
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            // throttle opcional
            \Illuminate\Routing\Middleware\ThrottleRequests::class.':api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,

            /* protege todo o grupo (opcional)
             * se preferir proteger rota-a-rota, remova esta linha
             */
            'auth:api',
        ],
    ];

    /**
     * ➌  Aliases usados nas rotas  ──────────────────────────────
     */
    protected array $routeMiddleware = [
        // padrão Laravel
        'auth'       => \App\Http\Middleware\Authenticate::class,
        'guest'      => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle'   => \Illuminate\Routing\Middleware\ThrottleRequests::class,

        // JWT-Auth
        'auth:api'   => JwtAuthenticate::class,                // exige token
        'jwt.refresh'=> \Tymon\JWTAuth\Http\Middleware\RefreshToken::class,
    ];
}
