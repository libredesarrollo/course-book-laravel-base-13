<?php

namespace App\Helpers;

class DemoMode
{
    public static function check(): void
    {
        if (config('demo.enabled')) {
            abort(403, 'Modo demo activo: no se permiten operaciones de escritura.');
        }
    }
}
