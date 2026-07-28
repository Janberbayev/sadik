<?php

namespace App\Http\Requests;

use App\Http\Requests\Concerns\HandlesProgramGroupImageUpload;
use Illuminate\Foundation\Http\FormRequest;

class ProgramGroupUpdateRequest extends FormRequest
{
    use HandlesProgramGroupImageUpload;
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
            'title' => ['required', 'string', 'max:2000'],
            'image' => ['nullable', 'file', 'image', 'max:5120'],
            'items_raw' => ['nullable', 'string', 'max:8000'],
        ];
    }

    /**
     * @return array<int, string>
     */
    public function parsedItems(): array
    {
        $raw = $this->string('items_raw')->toString();

        return ProgramGroupStoreRequest::normalizeItemsLines($raw);
    }
}
