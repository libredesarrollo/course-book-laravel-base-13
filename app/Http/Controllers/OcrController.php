<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ocr\ExtractTextRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Mayaram\LaravelOcr\Exceptions\OCRException;
use Mayaram\LaravelOcr\Facades\LaravelOcr;

class OcrController extends Controller
{
    public function create(): View
    {
        return view('ocr.create');
    }

    public function store(ExtractTextRequest $request): View
    {
        $file = $request->file('document');
        $path = $file->store('ocr', 'local');

        $options = array_filter([
            'language' => $request->string('language')->toString() ?: null,
        ]);

        try {
            $result = LaravelOcr::extract(Storage::disk('local')->path($path), $options);
        } catch (OCRException $e) {
            report($e);

            return view('ocr.create', [
                'error' => 'No se pudo leer el documento: '.$e->getMessage(),
                'oldLanguage' => $request->string('language')->toString(),
            ]);
        }

        return view('ocr.result', [
            'fileName' => $file->getClientOriginalName(),
            'result' => $result,
        ]);
    }
}
