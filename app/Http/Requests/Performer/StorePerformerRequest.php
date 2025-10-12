<?php

namespace App\Http\Requests\Performer;

use Illuminate\Foundation\Http\FormRequest;

class StorePerformerRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'home_description' => 'required|string|max:500',
            'detailed_description' => 'required|string|max:1000',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:1024',
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
            'name.required' => 'The performer name is required.',
            'name.max' => 'The performer name may not be greater than 255 characters.',
            'position.required' => 'The performer position is required.',
            'position.max' => 'The performer position may not be greater than 255 characters.',
            'home_description.required' => 'The home description is required.',
            'home_description.max' => 'The home description may not be greater than 500 characters.',
            'detailed_description.required' => 'The detailed description is required.',
            'detailed_description.max' => 'The detailed description may not be greater than 1000 characters.',
            'image.required' => 'The performer image is required.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
            'image.max' => 'The image may not be greater than 1MB.',
        ];
    }
}
