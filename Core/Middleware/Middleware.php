<?php

namespace Core\Middleware;

class Middleware
{
    public const MAP = [
        'auth' => Auth::class,
        'administrador' => Auth::class,
        'estudiante' => Auth::class,
        'instructor' => Auth::class,
    ];

    public function resolve($nombre)
    {
        if (!$nombre) {
            return;
        }

        $middleware = static::MAP[$nombre] ?? false;

        if (!$middleware) {
            throw new \Exception(
                "No middleware found with name {$nombre}"
            );
        }

        $rolRequerido = $nombre === 'auth' ? null : $nombre;

        (new $middleware())->handle($rolRequerido);
    }
}