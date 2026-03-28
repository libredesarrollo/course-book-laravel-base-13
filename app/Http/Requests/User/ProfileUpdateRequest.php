<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'address' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|max:2048',
        ];
    }
}
