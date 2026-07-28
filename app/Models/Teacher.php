<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'full_name',
        'position',
        'experience',
        'sort_order',
    ];

    /**
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function avatarStyle(): string
    {
        $backgrounds = ['#DBEEFF', '#DCFAE8', '#FFE9E6', '#EDE9FF'];
        $colors = ['#185FA5', '#0F6E56', '#993C1D', '#534AB7'];
        $i = (int) $this->sort_order % 4;

        return "background:{$backgrounds[$i]};color:{$colors[$i]};";
    }

    public function avatarEmoji(): string
    {
        $icons = ['👩‍🏫', '👩‍🎨', '🧑‍💻', '👩‍⚕️'];

        return $icons[(int) $this->sort_order % 4];
    }
}
