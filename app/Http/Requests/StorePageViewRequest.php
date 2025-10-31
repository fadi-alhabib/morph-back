<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePageViewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // public tracking, no auth
    }

    public function rules(): array
    {
        return [
            'path' => ['required', 'string', 'max:255'],
            'method' => ['nullable', 'string', 'max:10'],
            'referer' => ['nullable', 'string', 'max:255'],
        ];
    }
}
