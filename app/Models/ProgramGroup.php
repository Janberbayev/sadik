<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ProgramGroup extends Model
{
    protected $fillable = [
        'title',
        'image_path',
        'items',
        'sort_order',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'items' => 'array',
        ];
    }

    /**
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    /**
     * @return array<int, string>
     */
    public function bulletItems(): array
    {
        $lines = $this->items ?? [];

        return array_values(array_filter(array_map(
            fn ($line) => is_string($line) ? trim($line) : '',
            $lines
        )));
    }

    public function headerAccentClass(): string
    {
        $styles = ['bg-sky', 'bg-sun', 'bg-grass', 'bg-coral'];

        return $styles[(int) $this->sort_order % 4];
    }

    public function headerEmoji(): string
    {
        $icons = ['🐣', '🌱', '🌻', '🚀'];

        return $icons[(int) $this->sort_order % 4];
    }

    public function hasImage(): bool
    {
        return filled($this->image_path);
    }

    public function assetUrl(): string
    {
        $path = ltrim(str_replace('\\', '/', (string) $this->image_path), '/');

        return '/storage/'.$path;
    }
}
