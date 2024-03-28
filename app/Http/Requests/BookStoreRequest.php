<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookStoreRequest extends FormRequest
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
            'title' => 'required|string',
            'cover' => 'required|image',
            'author' => 'required|string',
            'genre' => 'required|string',
            'series' => 'nullable|string',
            'description' => 'required|string',
            'isbn' => 'required|string|unique:books',
            'publisher' => 'required|string',
            'pages' => 'required|numeric'
        ];
    }
}
