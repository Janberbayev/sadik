<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class GalleryItem extends Model
{
    protected $fillable = [
        'path',
        'caption',
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

    /**
     * Корневой путь вида /storage/... — работает при любом хосте и порте ( Artisan serve, localhost:8000 и т.д.),
     * в отличие от Storage::url(), которая жёстко опирается на APP_URL без порта.
     */
    public function assetUrl(): string
    {
        $path = ltrim(str_replace('\\', '/', (string) $this->path), '/');

        return '/storage/'.$path;
    }
}
