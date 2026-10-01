@extends('dashboard.layout')

@section('content')
    <div class="max-w-3xl mx-auto px-6 space-y-6">
        <div class="bg-white rounded-xl shadow p-6">
            <h1 class="text-2xl font-bold mb-6">Texto extraído</h1>

            <dl class="grid grid-cols-2 gap-4 text-sm mb-6">
                <div>
                    <dt class="text-gray-500">Archivo</dt>
                    <dd class="font-semibold">{{ $fileName }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Motor</dt>
                    <dd class="font-semibold">{{ $result['metadata']['engine'] ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Idioma</dt>
                    <dd class="font-semibold">{{ $result['metadata']['language'] ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Confianza</dt>
                    <dd class="font-semibold">{{ round(($result['confidence'] ?? 0) * 100, 1) }}%</dd>
                </div>
            </dl>

            <h2 class="text-sm font-semibold text-gray-500 mb-2">Texto detectado</h2>
            <pre class="bg-gray-900 text-gray-100 rounded-lg p-4 text-sm whitespace-pre-wrap max-h-96 overflow-auto">{{ $result['text'] ?? '' }}</pre>

            <a href="{{ route('ocr.create') }}"
               class="inline-block mt-6 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg">
                Subir otro documento
            </a>
        </div>
    </div>

    <p>Las migraciones son opcionales: </p>
<li>1. ocr_templates — plantillas que definen cómo extraer campos de un tipo de documento (ej. "mi factura tiene el número en X con regex Y").</li>
<li>2. ocr_template_fields — los campos de cada plantilla (invoice_number, total, etc.) con su regex y posición.</li>
<li>3. ocr_processed_documents — historial de documentos procesados: texto extraído, confianza, tiempo, a qué usuario pertenece.</li>
@endsection