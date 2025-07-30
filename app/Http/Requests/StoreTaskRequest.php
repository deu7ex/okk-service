<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'audio_url'  => 'required|url',
            'parameters' => 'nullable|array',
            'metadata'   => 'nullable|array',
        ];
    }
}

