<?php

use App\Http\Controllers\Api\SSEController;

describe('SSEController', function () {
    describe('stream', function () {
        it('returns an SSE response with the correct headers', function () {
            $response = $this->get('/api/v1/events');

            $response->assertOk();
            expect($response->headers->get('Cache-Control'))->toContain('no-cache');
            $response->assertHeader('Content-Type', 'text/event-stream; charset=utf-8');
            $response->assertHeader('Connection', 'keep-alive');
            $response->assertHeader('X-Accel-Buffering', 'no');
        });

        it('streams events in the SSE format', function () {
            $controller = new SSEController;

            $event = $controller->formatEvent(1);

            expect($event)
                ->toMatch('/^data: \{"message":"Notificación #1",/')
                ->toEndWith("\n\n");
        });

        it('encodes event payloads as valid JSON without escaping accents', function () {
            $controller = new SSEController;

            $json = trim(substr($controller->formatEvent(2), strlen('data: ')));

            expect(json_decode($json, true))
                ->toMatchArray(['message' => 'Notificación #2']);
        });

        it('formats the closing event with the closed name', function () {
            $controller = new SSEController;

            expect($controller->formatClosedEvent())
                ->toStartWith('event: closed')
                ->toContain('"message":"Stream finalizado"');
        });
    });
});
