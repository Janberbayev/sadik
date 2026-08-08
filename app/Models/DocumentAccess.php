<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentAccess extends Model
{
    protected $table = 'document_access';

    protected $fillable = [
        'login',
        'password',
    ];

    // Пароль хранится открытым текстом: это общий пароль для посетителей,
    // и админы должны всегда видеть его в панели.

    /** Единственная строка настроек доступа (создаётся при первом обращении). */
    public static function current(): self
    {
        return static::query()->firstOrCreate([]);
    }

    /** Логин и пароль заданы — раздел под защитой. */
    public function isConfigured(): bool
    {
        return filled($this->login) && filled($this->password);
    }
}
