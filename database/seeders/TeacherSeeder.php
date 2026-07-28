<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Teacher::query()->exists()) {
            return;
        }

        $pedagogues = [
            [
                'full_name' => 'Ирина Петрова',
                'position' => 'Старший воспитатель',
                'experience' => 'Опыт 15 лет',
            ],
            [
                'full_name' => 'Мария Волкова',
                'position' => 'Педагог по рисованию',
                'experience' => 'Опыт 9 лет',
            ],
            [
                'full_name' => 'Алексей Смирнов',
                'position' => 'STEM и математика',
                'experience' => 'Опыт 7 лет',
            ],
            [
                'full_name' => 'Светлана Ким',
                'position' => 'Детский психолог',
                'experience' => 'Опыт 12 лет',
            ],
        ];

        foreach ($pedagogues as $i => $row) {
            Teacher::query()->create([
                'full_name' => $row['full_name'],
                'position' => $row['position'],
                'experience' => $row['experience'],
                'sort_order' => $i,
            ]);
        }
    }
}
