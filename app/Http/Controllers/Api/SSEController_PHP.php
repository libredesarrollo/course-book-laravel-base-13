<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SSEController extends Controller
{
    public function stream(): StreamedResponse
    {
        return response()->stream(function () {
            // Desactivar el buffering de salida de PHP para enviar datos al instante
            if (ob_get_level() > 0) {
                ob_end_flush();
            }
            flush();

            // Ejemplo: Simulamos el envío de datos en vivo durante 10 iteraciones
            for ($i = 1; $i <= 10; $i++) {
                if (connection_aborted()) {
                    break;
                }

                echo $this->formatEvent($i);

                // Forzar a PHP a escupir los datos a través del socket HTTP
                flush();

                // Esperar 2 segundos antes de enviar el siguiente evento
                sleep(2);
            }

            // Avisamos al cliente para que cierre la conexión sin intentar reconectarse
            echo $this->formatClosedEvent();
            flush();
        }, 200, $this->sseHeaders());
    }

    /**
     * Formato obligatorio de SSE: data: {JSON}\n\n
     */
    public function formatEvent(int $iteration): string
    {
        $data = json_encode([
            'message' => "Notificación #{$iteration}",
            'time' => now()->toTimeString(),
        ], JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);

        return "data: {$data}\n\n";
    }

    /**
     * Evento final para que el cliente cierre la conexión limpiamente.
     */
    public function formatClosedEvent(): string
    {
        return "event: closed\ndata: {\"message\":\"Stream finalizado\"}\n\n";
    }

    /**
     * Cabeceras necesarias para mantener viva la conexión SSE.
     *
     * @return array<string, string>
     */
    public function sseHeaders(): array
    {
        return [
            'Cache-Control' => 'no-cache',
            'Content-Type' => 'text/event-stream; charset=utf-8',
            'Connection' => 'keep-alive',
            'X-Accel-Buffering' => 'no', // Necesario para servidores Nginx
        ];
    }
}
