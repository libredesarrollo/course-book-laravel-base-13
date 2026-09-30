<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OCR - Subir documento</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 py-10">
    <div class="max-w-2xl mx-auto px-6">
        <div class="bg-white rounded-xl shadow p-6">
            <h1 class="text-2xl font-bold mb-2">OCR con Tesseract</h1>
            <p class="text-sm text-gray-500 mb-6">Sube una imagen (png, jpg, tiff, bmp) o un PDF y extraemos su texto.</p>

            @isset($error)
                <div class="mb-6 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3">
                    {{ $error }}
                </div>
            @endisset

            @if ($errors->any())
                <div class="mb-6 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3">
                    <ul class="list-disc ps-5 space-y-1">
                        @foreach ($errors->all() as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('ocr.store') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <div>
                    <label for="document" class="block text-sm font-semibold mb-2">Documento</label>
                    <input id="document" name="document" type="file" required
                           accept=".png,.jpg,.jpeg,.pdf,.tiff,.bmp"
                           class="block w-full text-sm text-gray-600 file:mr-4 file:rounded-lg file:border-0 file:bg-blue-600 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-blue-700">
                </div>

                <div>
                    <label for="language" class="block text-sm font-semibold mb-2">Idioma</label>
                    <select id="language" name="language"
                            class="block w-full rounded-lg border border-gray-300 p-2 text-sm">
                        @foreach (['eng' => 'Inglés', 'spa' => 'Español', 'eng+spa' => 'Inglés + Español'] as $value => $label)
                            <option value="{{ $value }}" @selected(($oldLanguage ?? 'eng') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg">
                    Extraer texto
                </button>
            </form>
        </div>
    </div>
</body>
</html>
