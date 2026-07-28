<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteContact extends Model
{
    protected $fillable = [
        'address',
        'phone',
        'phone_2',
        'working_hours',
        'email',
        'about_text',
        'about_title',
        'programs_eyebrow',
        'programs_title',
    ];

    /**
     * Значения по умолчанию для формы и лендинга, пока нет записи в БД.
     *
     * @return array<string, string>
     */
    public static function defaultPayload(): array
    {
        return [
            'address' => "ул. Ленина, 42\nг. Актау",
            'phone' => '+7 (700) 123-45-67',
            'phone_2' => '',
            'working_hours' => "Пн–Пт\n7:00 — 19:00",
            'email' => 'info@solnyshko-sad.kz',
            'about_text' => 'Более 12 лет мы создаём пространство, в котором каждый ребёнок чувствует себя любимым и особенным. Наша миссия — помочь детям раскрыть таланты, найти друзей и полюбить учёбу.',
            'about_title' => "Детство, полное\nтепла и открытий",
            'programs_eyebrow' => 'Группы',
            'programs_title' => 'Программы для каждого возраста',
        ];
    }

    /** Единственная запись контактов (лендинг показывает первую строку таблицы). */
    public static function current(): ?self
    {
        return static::query()->first();
    }

    /** Отображение на лендинге: сохранённые поля или запасные дефолты. */
    public static function forPublicPage(?self $row): array
    {
        $defaults = self::defaultPayload();
        if (! $row) {
            return $defaults;
        }

        return [
            'address' => $row->address !== null && trim($row->address) !== '' ? $row->address : $defaults['address'],
            'phone' => $row->phone !== null && trim($row->phone) !== '' ? $row->phone : $defaults['phone'],
            'phone_2' => $row->phone_2 !== null && trim($row->phone_2) !== '' ? trim($row->phone_2) : '',
            'working_hours' => $row->working_hours !== null && trim($row->working_hours) !== '' ? $row->working_hours : $defaults['working_hours'],
            'email' => $row->email !== null && trim($row->email) !== '' ? $row->email : $defaults['email'],
            'about_text' => $row->about_text !== null && trim($row->about_text) !== '' ? $row->about_text : $defaults['about_text'],
            'about_title' => $row->about_title !== null && trim($row->about_title) !== '' ? $row->about_title : $defaults['about_title'],
            'programs_eyebrow' => $row->programs_eyebrow !== null && trim($row->programs_eyebrow) !== '' ? $row->programs_eyebrow : $defaults['programs_eyebrow'],
            'programs_title' => $row->programs_title !== null && trim($row->programs_title) !== '' ? $row->programs_title : $defaults['programs_title'],
        ];
    }

    /** Для формы: из БД или шаблон с дефолтами. */
    public static function forForm(): self
    {
        $row = static::current();

        return $row ?? new self(static::defaultPayload());
    }
}
