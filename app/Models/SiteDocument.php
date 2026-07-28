<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection as SupportCollection;

class SiteDocument extends Model
{
    protected $fillable = [
        'title',
        'link_root',
        'file_title',
        'path',
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

    public function assetUrl(): string
    {
        $path = ltrim(str_replace('\\', '/', (string) $this->path), '/');

        return $path !== '' ? '/storage/'.$path : '#';
    }

    public function hasFile(): bool
    {
        return filled($this->path);
    }

    /** Имя файла для показа: «Название файла» или название документа. */
    public function displayFileTitle(): string
    {
        return filled($this->file_title) ? (string) $this->file_title : (string) $this->title;
    }

    /** Последний сегмент пути папки: «завтра/2025» → «2025». */
    public function folderDisplayName(): string
    {
        $root = (string) ($this->link_root ?? '');
        if ($root === '') {
            return '';
        }

        $parts = explode('/', $root);

        return (string) end($parts);
    }

    /**
     * Дочерние папки одного уровня.
     * На корне документа — папки без «/»; внутри «завтра» — только «завтра/…» с одним сегментом.
     *
     * @return SupportCollection<int, static>
     */
    public function childFolders(): SupportCollection
    {
        $parent = self::normalizeLinkRoot($this->link_root);

        return static::query()
            ->where('title', $this->title)
            ->whereNotNull('link_root')
            ->where('link_root', '!=', '')
            ->ordered()
            ->get()
            ->unique('link_root')
            ->filter(function (self $doc) use ($parent) {
                $path = (string) $doc->link_root;

                if ($parent === null) {
                    return ! str_contains($path, '/');
                }

                $prefix = $parent.'/';
                if (! str_starts_with($path, $prefix)) {
                    return false;
                }

                $rest = substr($path, strlen($prefix));

                return $rest !== '' && ! str_contains($rest, '/');
            })
            ->values();
    }

    /** Файлы в этой папке (точный путь link_root). */
    public function folderFiles(): Collection
    {
        return static::query()
            ->where('title', $this->title)
            ->where('link_root', $this->link_root)
            ->whereNotNull('path')
            ->where('path', '!=', '')
            ->ordered()
            ->get();
    }

    /** Родительская запись (папка уровнем выше или документ). */
    public function parentDocument(): ?self
    {
        $root = self::normalizeLinkRoot($this->link_root);

        if ($root === null) {
            return null;
        }

        if (! str_contains($root, '/')) {
            return static::query()
                ->where('title', $this->title)
                ->ordered()
                ->first();
        }

        $parentPath = substr($root, 0, (int) strrpos($root, '/'));

        return static::query()
            ->where('title', $this->title)
            ->where('link_root', $parentPath)
            ->ordered()
            ->first()
            ?? static::query()->where('title', $this->title)->ordered()->first();
    }

    /** Публичный URL страницы этой записи (папка или документ). */
    public function publicPageUrl(): string
    {
        if ($this->link_root) {
            return locale_route('documents.folder', ['site_document' => $this]);
        }

        return locale_route('documents.show', ['site_document' => $this]);
    }

    /** URL страницы в панели dashboard. */
    public function dashboardPageUrl(): string
    {
        if ($this->link_root) {
            return route('dashboard.docs.folder', ['site_document' => $this]);
        }

        return route('dashboard.docs.show', ['site_document' => $this]);
    }

    /** Нормализует корень: «устав/ 2024-2025/» → «устав/2024-2025». */
    public static function normalizeLinkRoot(?string $root): ?string
    {
        if ($root === null) {
            return null;
        }

        $root = str_replace('\\', '/', $root);
        $root = preg_replace('#/+#', '/', $root) ?? $root;
        $root = trim($root);
        $root = trim($root, '/');
        $parts = array_values(array_filter(
            array_map(static fn (string $part): string => trim($part), explode('/', $root)),
            static fn (string $part): bool => $part !== ''
        ));

        if ($parts === []) {
            return null;
        }

        return implode('/', $parts);
    }

    /** Полный путь ссылки: «устав/2024-2025/устав документ». */
    public function linkPath(): string
    {
        $root = self::normalizeLinkRoot($this->link_root);

        return $root ? $root.'/'.$this->title : (string) $this->title;
    }
}
