<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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
     * Гарантирует, что для каждого пути папки существуют записи всех промежуточных уровней.
     * Чинит «висящие» файлы, у которых родительская папка не представлена записью
     * (иначе они не видны в навигации, хотя видны в дереве переноса).
     */
    public static function ensureFolderNodes(string $title): void
    {
        $rows = static::query()->where('title', $title)->get();

        $existing = $rows
            ->map(fn (self $row): ?string => self::normalizeLinkRoot($row->link_root))
            ->filter()
            ->unique()
            ->flip();

        $missing = [];

        foreach ($existing->keys() as $path) {
            $segments = explode('/', $path);
            $accum = '';

            for ($i = 0; $i < count($segments) - 1; $i++) {
                $accum = $accum === '' ? $segments[$i] : $accum.'/'.$segments[$i];

                if (! $existing->has($accum) && ! isset($missing[$accum])) {
                    $missing[$accum] = true;
                }
            }
        }

        foreach (array_keys($missing) as $path) {
            static::query()->create([
                'title' => $title,
                'link_root' => $path,
                'path' => null,
                'sort_order' => (int) static::query()->max('sort_order') + 1,
            ]);
        }
    }

    /**
     * Дочерние папки одного уровня.
     * На корне документа — папки без «/»; внутри «завтра» — только «завтра/…» с одним сегментом.
     *
     * @return SupportCollection<int, static>
     */
    public function childFolders(string $sort = 'name'): SupportCollection
    {
        $parent = self::normalizeLinkRoot($this->link_root);

        $folders = static::query()
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

        return self::sortItems($folders, $sort, true);
    }

    /** Файлы в этой папке (точный путь link_root). */
    public function folderFiles(string $sort = 'name'): SupportCollection
    {
        $files = static::query()
            ->where('title', $this->title)
            ->where('link_root', $this->link_root)
            ->whereNotNull('path')
            ->where('path', '!=', '')
            ->ordered()
            ->get();

        return self::sortItems($files, $sort, false);
    }

    /**
     * Сортировка списка папок/файлов по режиму: name (по умолчанию), date, manual.
     *
     * @param  SupportCollection<int, static>  $items
     * @return SupportCollection<int, static>
     */
    protected static function sortItems(SupportCollection $items, string $sort, bool $isFolder): SupportCollection
    {
        return match ($sort) {
            'date' => $items->sortByDesc('created_at')->values(),
            'manual' => $items->sortBy('id')->sortBy('sort_order')->values(),
            default => $items
                ->sortBy(
                    fn (self $doc): string => mb_strtolower($isFolder ? $doc->folderDisplayName() : $doc->displayFileTitle()),
                    SORT_NATURAL
                )
                ->values(),
        };
    }

    /**
     * Дерево всех мест назначения (документы → вложенные папки) для переноса файлов.
     * Каждый узел: ['id' => представитель, 'name' => сегмент, 'children' => [...]].
     *
     * @return array<int, array{id:int,name:string,children:array<int,mixed>}>
     */
    public static function moveTree(): array
    {
        $byTitle = static::query()->ordered()->get()->groupBy('title');
        $tree = [];

        foreach ($byTitle as $title => $rows) {
            $root = $rows->firstWhere('link_root', null) ?? $rows->first();

            // Представитель (id первой записи) для каждого пути папки.
            $repByPath = [];
            foreach ($rows as $row) {
                $path = self::normalizeLinkRoot($row->link_root);
                if ($path !== null && ! isset($repByPath[$path])) {
                    $repByPath[$path] = $row->id;
                }
            }

            $paths = array_keys($repByPath);
            sort($paths, SORT_NATURAL | SORT_FLAG_CASE);

            $node = ['id' => $root->id, 'name' => (string) $title, 'children' => []];

            foreach ($paths as $path) {
                $segments = explode('/', $path);
                $cursor = &$node['children'];
                $accum = '';

                foreach ($segments as $segment) {
                    $accum = $accum === '' ? $segment : $accum.'/'.$segment;

                    $index = null;
                    foreach ($cursor as $i => $child) {
                        if ($child['path'] === $accum) {
                            $index = $i;
                            break;
                        }
                    }

                    if ($index === null) {
                        $cursor[] = [
                            'id' => $repByPath[$accum] ?? $root->id,
                            'name' => $segment,
                            'path' => $accum,
                            'children' => [],
                        ];
                        $index = array_key_last($cursor);
                    }

                    $cursor = &$cursor[$index]['children'];
                }

                unset($cursor);
            }

            $tree[] = $node;
        }

        return $tree;
    }

    /**
     * Корневая запись документа (link_root = null). Не зависит от sort_order,
     * поэтому ссылка «открыть документ» всегда ведёт на корень, а не в подпапку.
     */
    public static function documentRoot(string $title): ?self
    {
        return static::query()
            ->where('title', $title)
            ->whereNull('link_root')
            ->ordered()
            ->first()
            ?? static::query()->where('title', $title)->ordered()->first();
    }

    /** Родительская запись (папка уровнем выше или документ). */
    public function parentDocument(): ?self
    {
        $root = self::normalizeLinkRoot($this->link_root);

        if ($root === null) {
            return null;
        }

        if (! str_contains($root, '/')) {
            return self::documentRoot($this->title);
        }

        $parentPath = substr($root, 0, (int) strrpos($root, '/'));

        return static::query()
            ->where('title', $this->title)
            ->where('link_root', $parentPath)
            ->ordered()
            ->first()
            ?? self::documentRoot($this->title);
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
