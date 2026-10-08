<?php

use Illuminate\Support\Facades\Process;

describe('PythonAnalyzerController', function () {
    it('returns the JSON produced by the Python script', function () {
        Process::fake([
            '*python3*' => Process::result(output: json_encode([
                'status' => 'success',
                'file_name' => 'sample.png',
                'extension' => '.png',
                'size_bytes' => 1639,
                'size_kb' => 1.6,
                'width' => 640,
                'height' => 400,
                'absolute_path' => storage_path('app/public/sample.png'),
            ])),
        ]);

        $this->getJson(route('python.analyze', ['file' => 'sample.png']))
            ->assertOk()
            ->assertJsonPath('laravel_status', 'OK')
            ->assertJsonPath('python_response.status', 'success')
            ->assertJsonPath('python_response.width', 640)
            ->assertJsonPath('python_response.height', 400);
    });

    it('passes the absolute file path as a python argument', function () {
        Process::fake(['*python3*' => Process::result(output: json_encode(['status' => 'success']))]);

        $this->getJson(route('python.analyze', ['file' => 'sample.png']))->assertOk();

        Process::assertRan(function ($process) {
            $command = implode(' ', (array) $process->command);

            return str_contains($command, base_path('app/Python/analyzer.py'))
                && str_contains($command, storage_path('app/public/sample.png'));
        });
    });

    it('analyzes sample.png by default when no file is given', function () {
        Process::fake(['*python3*' => Process::result(output: json_encode(['status' => 'success']))]);

        $this->getJson(route('python.analyze'))->assertOk();

        Process::assertRan(function ($process) {
            $command = implode(' ', (array) $process->command);

            return str_contains($command, storage_path('app/public/sample.png'));
        });
    });

    it('rejects file names that try to escape the public directory', function (string $file) {
        Process::preventStrayProcesses();
        Process::fake();

        $this->getJson(route('python.analyze', ['file' => $file]))
            ->assertStatus(422)
            ->assertJsonPath('laravel_status', 'ERROR');
    })->with([
        '../../.env',
        'nested/sample.png',
        '',
    ]);

    it('returns the error reported by python when the file does not exist', function () {
        Process::fake([
            '*python3*' => Process::result(
                output: json_encode(['error' => 'El archivo no existe']),
                exitCode: 1,
                errorOutput: 'El archivo no existe',
            ),
        ]);

        $this->getJson(route('python.analyze', ['file' => 'missing.png']))
            ->assertStatus(422)
            ->assertJsonPath('message', 'El archivo no existe');
    });

    it('fails when the script does not return valid json', function () {
        Process::fake(['*python3*' => Process::result(output: 'not-json')]);

        $this->getJson(route('python.analyze'))
            ->assertStatus(422)
            ->assertJsonPath('message', 'El script de Python no devolvió un JSON válido.');
    });

    it('really runs the script against the bundled sample image', function () {
        Process::preventStrayProcesses();

        $sample = storage_path('app/public/sample.png');

        if (! is_file($sample) || ! is_executable(trim(shell_exec('command -v '.config('services.python.binary')) ?: ''))) {
            $this->markTestSkipped('Python o la imagen de ejemplo no están disponibles.');
        }

        $this->getJson(route('python.analyze'))
            ->assertOk()
            ->assertJsonPath('laravel_status', 'OK')
            ->assertJsonPath('python_response.file_name', 'sample.png')
            ->assertJsonPath('python_response.width', 640)
            ->assertJsonPath('python_response.height', 400);
    });
});
