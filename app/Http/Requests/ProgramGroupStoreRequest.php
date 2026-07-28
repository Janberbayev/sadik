<?php

namespace App\Http\Requests;

use App\Http\Requests\Concerns\HandlesProgramGroupImageUpload;
use App\Models\ProgramGroup;
use Illuminate\Foundation\Http\FormRequest;

class ProgramGroupStoreRequest extends FormRequest
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

        return self::normalizeItemsLines($raw);
    }

    public function validatedNextSort(): int
    {
        return (int) ProgramGroup::query()->max('sort_order') + 1;
    }

    /**
     * @return array<int, string>
     */
    public static function normalizeItemsLines(string $text): array
    {
        $lines = preg_split('/\r\n|\r|\n/', $text) ?: [];

        return array_values(array_filter(array_map('trim', $lines), fn ($line) => $line !== ''));
    }
}
