<?php

namespace App\Http\Requests\Home;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHomeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'whatsapp_link' => 'nullable|string|url|max:255',
            'x_link' => 'nullable|string|url|max:255',
            'youtube_link' => 'nullable|string|url|max:255',
            'instagram_link' => 'nullable|string|url|max:255',
            'phone_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'location' => 'nullable|string|max:255',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'whatsapp_link.url' => 'The WhatsApp link must be a valid URL.',
            'x_link.url' => 'The X (Twitter) link must be a valid URL.',
            'youtube_link.url' => 'The YouTube link must be a valid URL.',
            'instagram_link.url' => 'The Instagram link must be a valid URL.',
            'phone_number.max' => 'The phone number may not be greater than 20 characters.',
            'email.email' => 'The email must be a valid email address.',
            'email.max' => 'The email may not be greater than 255 characters.',
            'location.max' => 'The location may not be greater than 255 characters.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'whatsapp_link' => 'WhatsApp link',
            'x_link' => 'X (Twitter) link',
            'youtube_link' => 'YouTube link',
            'instagram_link' => 'Instagram link',
            'phone_number' => 'phone number',
            'email' => 'email address',
            'location' => 'location',
        ];
    }
}
