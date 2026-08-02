<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SiteDocumentStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'link_root' => ['nullable', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            /** PDF и распространённые изображения (до 20 МБ). */
            'file' => ['required', 'file', 'max:20480', 'mimes:pdf,jpeg,jpg,png,gif,webp'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'file.required' => 'Выберите файл документа.',
            'file.mimes' => 'Допустимые форматы: PDF, JPEG, JPG, PNG, GIF, WebP.',
        ];
    }
}
