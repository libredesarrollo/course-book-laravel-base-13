<?php

namespace App\Http\Requests\Ocr;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExtractTextRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'document' => [
                'required',
                'file',
                'mimes:'.implode(',', config('laravel-ocr.processing.allowed_formats', ['jpg', 'jpeg', 'png', 'pdf', 'tiff', 'bmp'])),
                'mimetypes:'.implode(',', config('laravel-ocr.security.allowed_mime_types', [])),
                'max:'.config('laravel-ocr.processing.max_file_size', 10240),
            ],
            'language' => ['sometimes', 'string', Rule::in(['eng', 'spa', 'eng+spa'])],
        ];
    }

    public function messages(): array
    {
        return [
            'document.required' => 'Debes subir una imagen o un PDF.',
            'document.mimes' => 'Formato no soportado. Usa: jpg, jpeg, png, pdf, tiff o bmp.',
            'document.mimetypes' => 'El tipo de archivo no coincide con un formato permitido.',
            'document.max' => 'El archivo supera el tamaño máximo permitido (10 MB).',
        ];
    }
}
