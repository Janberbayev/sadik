<?php

namespace Database\Seeders;

use App\Models\ProgramGroup;
use Illuminate\Database\Seeder;

class ProgramGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (ProgramGroup::query()->exists()) {
            return;
        }

        $groups = [
            [
                'title' => 'Ясли'."\n".'1,5 — 3 года',
                'items' => ['Адаптация к садику', 'Сенсорные игры', 'Развитие речи', 'Музыка и движение', '5-разовое питание'],
            ],
            [
                'title' => 'Младшая'."\n".'3 — 4 года',
                'items' => ['Рисование и лепка', 'Основы английского', 'Развитие моторики', 'Ролевые игры', 'Прогулки 2 раза в день'],
            ],
            [
                'title' => 'Средняя'."\n".'4 — 5 лет',
                'items' => ['STEM-игры и логика', 'Театр и выступления', 'Спортивные секции', 'Английский 3×/нед', 'Подготовка к школе'],
            ],
            [
                'title' => 'Старшая'."\n".'5 — 7 лет',
                'items' => ['Подготовка к школе', 'Чтение и письмо', 'Математика и логика', 'Робототехника', 'Портфолио достижений'],
            ],
        ];

        foreach ($groups as $i => $g) {
            ProgramGroup::query()->create([
                'title' => $g['title'],
                'items' => $g['items'],
                'sort_order' => $i,
            ]);
        }
    }
}
