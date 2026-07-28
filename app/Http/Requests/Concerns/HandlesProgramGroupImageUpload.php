<?php

namespace App\Http\Requests\Concerns;

use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;

trait HandlesProgramGroupImageUpload
{
    protected function prepareForValidation(): void
    {
        $this->guardAgainstBrokenImageUpload();
    }

    protected function guardAgainstBrokenImageUpload(): void
    {
        if (! isset($_FILES['image'])) {
            return;
        }

        $error = (int) ($_FILES['image']['error'] ?? UPLOAD_ERR_NO_FILE);

        if ($error === UPLOAD_ERR_NO_FILE) {
            return;
        }

        if (in_array($error, [UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE], true)) {
            throw ValidationException::withMessages([
                'image' => ['Файл слишком большой. Максимум 5 МБ.'],
            ]);
        }

        if ($error !== UPLOAD_ERR_OK) {
            throw ValidationException::withMessages([
                'image' => ['Не удалось загрузить файл. Выберите изображение JPEG, PNG, WebP или GIF.'],
            ]);
        }
    }

    public function storedImagePathIfUploaded(): ?string
    {
        /** @var UploadedFile|null $file */
        $file = $this->file('image');

        if ($file === null) {
            return null;
        }

        if (! $file->isValid()) {
            throw ValidationException::withMessages([
                'image' => ['Не удалось сохранить изображение. Попробуйте другой файл (до 5 МБ).'],
            ]);
        }

        return $file->store('program-groups', 'public');
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator): void
    {
        $redirect = $this->getRedirectUrl();
        $fragment = str_contains($redirect, '#') ? '' : '#panel-program-groups';

        throw (new ValidationException($validator))
            ->errorBag($this->errorBag)
            ->redirectTo($redirect.$fragment);
    }
}
