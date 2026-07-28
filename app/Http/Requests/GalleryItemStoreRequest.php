<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GalleryItemStoreRequest extends FormRequest
{
    /** Максимум файлов за одну отправку формы (ограничение по нагрузке на сервер). */
    public const MAX_FILES_PER_UPLOAD = 30;

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
            'images' => ['required', 'array', 'min:1', 'max:'.self::MAX_FILES_PER_UPLOAD],
            'images.*' => ['file', 'image', 'max:5120'],
            'caption' => ['nullable', 'string', 'max:500'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'images.required' => 'Выберите хотя бы один файл изображения.',
            'images.max' => 'За один раз можно загрузить не более :max файлов.',
        ];
    }
}
