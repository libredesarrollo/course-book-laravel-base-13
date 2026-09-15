<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SSEController extends Controller
{
    public function stream(): StreamedResponse
    {
        return response()->stream(function () {
            for ($i = 1; $i <= 10; $i++) {
                // connection_aborted() sigue siendo necesario en bucles imperativos
                if (connection_aborted()) {
                    break;
                }

                $this->sendSseEvent('message', [
                    'message' => "Notificación #{$i}",
                    'time' => now()->toTimeString(),
                ]);

                sleep(2);
            }

            // Evento de cierre explícito
            $this->sendSseEvent('closed', ['message' => 'Stream finalizado']);
        }, 200, $this->sseHeaders());
    }

    /**
     * Helper para emitir eventos formateados según la especificación SSE
     */
    private function sendSseEvent(string $event, array $data): void
    {
        echo "event: {$event}\n";
        echo 'data: ' . json_encode($data, JSON_UNESCAPED_UNICODE) . "\n\n";

        if (ob_get_level() > 0) {
            ob_flush();
        }
        flush();
    }

    private function sseHeaders(): array
    {
        return [
            'Cache-Control' => 'no-cache',
            'Content-Type' => 'text/event-stream; charset=utf-8',
            'Connection' => 'keep-alive',
            'X-Accel-Buffering' => 'no',
        ];
    }
}