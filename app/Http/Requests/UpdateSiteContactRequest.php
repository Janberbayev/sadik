<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSiteContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $section = $this->input('_section');

        return match ($section) {
            'contacts' => [
                '_section' => ['required', 'string', Rule::in(['contacts'])],
                'address' => ['nullable', 'string', 'max:2000'],
                'phone' => ['nullable', 'string', 'max:255'],
                'phone_2' => ['nullable', 'string', 'max:255'],
                'working_hours' => ['nullable', 'string', 'max:2000'],
                'email' => ['nullable', 'string', 'email', 'max:255'],
            ],
            'about' => [
                '_section' => ['required', 'string', Rule::in(['about'])],
                'about_text' => ['nullable', 'string', 'max:16000'],
                'about_title' => ['nullable', 'string', 'max:1000'],
            ],
            'programs' => [
                '_section' => ['required', 'string', Rule::in(['programs'])],
                'programs_eyebrow' => ['nullable', 'string', 'max:255'],
                'programs_title' => ['nullable', 'string', 'max:2000'],
            ],
            default => [
                '_section' => ['required', 'string', Rule::in(['contacts', 'about', 'programs'])],
            ],
        };
    }
}
