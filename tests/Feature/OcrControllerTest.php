<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Mayaram\LaravelOcr\Exceptions\OCRException;
use Mayaram\LaravelOcr\Facades\LaravelOcr;
use Tests\Fixtures\TextImage;

describe('OcrController', function () {
    it('shows the upload form', function () {
        $this->get(route('ocr.create'))
            ->assertOk()
            ->assertSee('OCR con Tesseract', escape: false);
    });

    it('rejects a request without a document', function () {
        $this->post(route('ocr.store'), [])
            ->assertSessionHasErrors('document');
    });

    it('rejects unsupported file formats', function () {
        Storage::fake('local');

        $this->post(route('ocr.store'), [
            'document' => UploadedFile::fake()->create('malware.exe', 10),
        ])->assertSessionHasErrors('document');
    });

    it('extracts the text from an uploaded image', function () {
        Storage::fake('local');

        LaravelOcr::shouldReceive('extract')
            ->once()
            ->withArgs(function (string $path, array $options): bool {
                // The driver reads the file from disk, so the path must really exist.
                expect($path)->toBeFile();
                expect($options)->toBe(['language' => 'eng']);

                return true;
            })
            ->andReturn([
                'text' => 'INVOICE #1001',
                'confidence' => 0.95,
                'bounds' => [],
                'metadata' => ['engine' => 'tesseract', 'language' => 'eng'],
            ]);

        $response = $this->post(route('ocr.store'), [
            'document' => UploadedFile::fake()->image('ocr.png'),
            'language' => 'eng',
        ]);

        $response->assertOk()
            ->assertSee('ocr.png')
            ->assertSee('INVOICE #1001')
            ->assertSee('95%');

        Storage::disk('local')->assertExists(collect(Storage::disk('local')->files('ocr'))->first());
    });

    it('shows the form again with an error when the driver fails', function () {
        Storage::fake('local');

        LaravelOcr::shouldReceive('extract')
            ->once()
            ->andThrow(new OCRException('binary not found'));

        $this->post(route('ocr.store'), [
            'document' => UploadedFile::fake()->image('ocr.png'),
        ])->assertOk()
            ->assertSee('No se pudo leer el documento', escape: false);
    });

    it('reads real text out of an uploaded image with the configured driver', function () {
        if (! is_executable(config('laravel-ocr.drivers.tesseract.binary'))) {
            $this->markTestSkipped('Tesseract binary is not installed.');
        }

        Storage::fake('local');

        $fixture = TextImage::make('Laravel OCR 12345');
        $image = new UploadedFile($fixture, 'ocr.png', 'image/png', null, true);

        $response = $this->post(route('ocr.store'), [
            'document' => $image,
            'language' => 'eng',
        ]);

        $response->assertOk()
            ->assertSee('Texto extraído')
            ->assertDontSee('No se pudo leer el documento')
            ->assertSee('Laravel OCR');

        @unlink($fixture);
    });
});
