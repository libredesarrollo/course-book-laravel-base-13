<?php

namespace App\Actions;

use Illuminate\Support\Facades\Process;
use RuntimeException;

/**
 * Ejecuta el script de Python app/Python/analyzer.py y devuelve su salida JSON.
 */
class AnalyzeFileWithPython
{
    /**
     * Analiza un archivo local pasando su ruta absoluta como argumento a Python.
     *
     * @return array<string, mixed>
     *
     * @throws RuntimeException Si el proceso falla o no devuelve JSON válido.
     */
    public function handle(string $absolutePath): array
    {
        $script = base_path('app/Python/analyzer.py');

        // El array de argumentos evita el shell: no hay que escapar comillas ni
        // quedan expuestos los comandos encadenados de la petición del usuario.
        // Utiliza la fachada Process (introducida en Laravel 10) para correr el archivo analyzer.py pasándole como argumento la ruta de un archivo ($absolutePath).
        $result = Process::path(dirname($script))
            ->timeout(30)
            ->run([
                config('services.python.binary', 'python3'),
                $script,
                $absolutePath,
            ]);

        $decoded = json_decode($result->output(), true);

        if ($result->failed()) {
            $message = $decoded['error'] ?? trim($result->errorOutput());

            throw new RuntimeException($message !== '' ? $message : 'El script de Python falló.');
        }

        if (! is_array($decoded)) {
            throw new RuntimeException('El script de Python no devolvió un JSON válido.');
        }

        return $decoded;
    }
}
