<?php

namespace App\Http\Controllers;

use App\Actions\AnalyzeFileWithPython;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

class PythonAnalyzerController extends Controller
{
    /**
     * Analiza un archivo de storage/app/public con el script de Python.
     *
     * GET /python/analyze?file=sample.jpeg
     */
    public function __invoke(Request $request, AnalyzeFileWithPython $analyze): JsonResponse
    {
        $file = $request->query('file', 'sample.png');

        // Solo se permiten nombres de archivo relativos dentro de storage/app/public:
        // cualquier ../intentaría leer fuera del directorio.
        if (! is_string($file) || $file === '' || str_contains($file, '/') || str_contains($file, '\\')) {
            return response()->json([
                'laravel_status' => 'ERROR',
                'message' => 'Indica un nombre de archivo válido, por ejemplo: ?file=sample.png',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $metadata = $analyze->handle(storage_path("app/public/{$file}"));
        } catch (RuntimeException $exception) {
            return response()->json([
                'laravel_status' => 'ERROR',
                'message' => $exception->getMessage(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json([
            'laravel_status' => 'OK',
            'python_response' => $metadata,
        ]);
    }
}
