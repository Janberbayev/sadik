<?php

namespace App\Http\Controllers;

use App\Models\SiteDocument;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class DashboardDocumentsController extends Controller
{
    public function index(Request $request): View
    {
        $sort = $this->sortMode($request);

        // Представитель документа — всегда корневая запись (link_root = null),
        // иначе после перетаскивания файлов ссылка открывала бы подпапку.
        $documents = SiteDocument::query()
            ->ordered()
            ->get()
            ->groupBy('title')
            ->map(fn ($group) => $group->firstWhere('link_root', null) ?? $group->first())
            ->values();

        $documents = match ($sort) {
            'date' => $documents->sortByDesc('created_at')->values(),
            'manual' => $documents->sortBy('id')->sortBy('sort_order')->values(),
            default => $documents->sortBy(fn (SiteDocument $doc): string => mb_strtolower((string) $doc->title), SORT_NATURAL)->values(),
        };

        return view('dashboard.documents.index', [
            'documents' => $documents,
            'sort' => $sort,
        ]);
    }

    public function show(Request $request, SiteDocument $site_document): View
    {
        $sort = $this->sortMode($request);
        SiteDocument::ensureFolderNodes($site_document->title);

        return view('dashboard.documents.show', [
            'document' => $site_document,
            'folders' => $site_document->childFolders($sort),
            'files' => $site_document->folderFiles($sort),
            'sort' => $sort,
            'moveTree' => SiteDocument::moveTree(),
        ]);
    }

    public function folder(Request $request, SiteDocument $site_document): View|RedirectResponse
    {
        if (! $site_document->link_root) {
            return redirect()->route('dashboard.docs.show', $site_document);
        }

        $parent = $site_document->parentDocument() ?: $site_document;
        $sort = $this->sortMode($request);
        SiteDocument::ensureFolderNodes($site_document->title);

        return view('dashboard.documents.folder', [
            'document' => $site_document,
            'parent' => $parent,
            'folders' => $site_document->childFolders($sort),
            'files' => $site_document->folderFiles($sort),
            'sort' => $sort,
            'moveTree' => SiteDocument::moveTree(),
        ]);
    }

    /** Режим сортировки: берём из query и запоминаем в сессии, иначе — последний выбранный. */
    private function sortMode(Request $request): string
    {
        $allowed = ['name', 'date', 'manual'];

        if ($request->has('sort')) {
            $sort = (string) $request->query('sort');
            $sort = in_array($sort, $allowed, true) ? $sort : 'name';
            $request->session()->put('docs_sort', $sort);

            return $sort;
        }

        $sort = (string) $request->session()->get('docs_sort', 'name');

        return in_array($sort, $allowed, true) ? $sort : 'name';
    }

    /** Добавляет к URL текущий режим сортировки (из сессии), чтобы фильтр не сбрасывался после действий. */
    private function withSort(string $url): string
    {
        $sort = (string) session('docs_sort', '');

        if (! in_array($sort, ['name', 'date', 'manual'], true)) {
            return $url;
        }

        return $url.(str_contains($url, '?') ? '&' : '?').'sort='.$sort;
    }

    public function storeTitle(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
        ], [
            'title.required' => 'Укажите название документа.',
        ]);

        $title = trim($validated['title']);

        if ($title === '') {
            return back()->withErrors(['title' => 'Укажите название документа.'])->withInput();
        }

        if (SiteDocument::query()->where('title', $title)->exists()) {
            return back()->withErrors(['title' => 'Такой документ уже есть.'])->withInput();
        }

        SiteDocument::query()->create([
            'title' => $title,
            'link_root' => null,
            'path' => null,
            'sort_order' => (int) SiteDocument::query()->max('sort_order') + 1,
        ]);

        return redirect()
            ->route('dashboard.docs.index')
            ->with('status', 'title-created');
    }

    /** Переименовать название документа — во всех записях этой ветки. */
    public function renameTitle(Request $request, SiteDocument $site_document): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
        ], [
            'title.required' => 'Укажите новое название документа.',
        ]);

        $newTitle = trim($validated['title']);

        if ($newTitle === '') {
            return back()->withErrors(['title' => 'Укажите новое название документа.'])->withInput();
        }

        $oldTitle = (string) $site_document->title;

        if ($newTitle === $oldTitle) {
            return redirect()
                ->route('dashboard.docs.show', $site_document)
                ->with('status', 'title-renamed');
        }

        $conflict = SiteDocument::query()
            ->where('title', $newTitle)
            ->exists();

        if ($conflict) {
            return back()->withErrors(['title' => 'Документ с таким названием уже есть.'])->withInput();
        }

        SiteDocument::query()
            ->where('title', $oldTitle)
            ->update(['title' => $newTitle]);

        $site_document->refresh();

        return redirect()
            ->route('dashboard.docs.show', $site_document)
            ->with('status', 'title-renamed');
    }

    /** Удалить весь документ (корневую папку) со всеми папками и файлами. */
    public function destroyTitle(SiteDocument $site_document): RedirectResponse
    {
        $docs = SiteDocument::query()
            ->where('title', $site_document->title)
            ->get();

        foreach ($docs as $doc) {
            if (filled($doc->path)) {
                Storage::disk('public')->delete($doc->path);
            }

            $doc->delete();
        }

        return redirect()
            ->route('dashboard.docs.index')
            ->with('status', 'document-deleted');
    }

    public function storeFolder(Request $request, SiteDocument $site_document): RedirectResponse
    {
        $validated = $request->validate([
            'link_root' => ['required', 'string', 'max:255'],
        ], [
            'link_root.required' => 'Укажите название папки.',
        ]);

        $segment = SiteDocument::normalizeLinkRoot($validated['link_root']);

        if (! $segment) {
            return back()->withErrors(['link_root' => 'Укажите название папки.'])->withInput();
        }

        if (str_contains($segment, '/')) {
            return back()->withErrors(['link_root' => 'В названии папки не используйте слэш.'])->withInput();
        }

        $parentPath = SiteDocument::normalizeLinkRoot($site_document->link_root);
        $folderName = $parentPath ? $parentPath.'/'.$segment : $segment;

        $exists = SiteDocument::query()
            ->where('title', $site_document->title)
            ->where('link_root', $folderName)
            ->exists();

        if ($exists) {
            return back()->withErrors(['link_root' => 'Такая папка уже есть.'])->withInput();
        }

        SiteDocument::query()->create([
            'title' => $site_document->title,
            'link_root' => $folderName,
            'path' => null,
            'sort_order' => (int) SiteDocument::query()->max('sort_order') + 1,
        ]);

        return redirect()
            ->to($this->withSort($site_document->dashboardPageUrl()))
            ->with('status', 'folder-created');
    }

    /** Переименовать папку (последний сегмент) и обновить пути у вложенных записей. */
    public function renameFolder(Request $request, SiteDocument $site_document): RedirectResponse
    {
        if (! $site_document->link_root) {
            return back()->withErrors(['folder_name' => 'Эту страницу нельзя переименовать как папку.']);
        }

        $validated = $request->validate([
            'folder_name' => ['required', 'string', 'max:255'],
        ], [
            'folder_name.required' => 'Укажите новое название папки.',
        ]);

        $newSegment = SiteDocument::normalizeLinkRoot($validated['folder_name']);

        if (! $newSegment) {
            return back()->withErrors(['folder_name' => 'Укажите новое название папки.'])->withInput();
        }

        if (str_contains($newSegment, '/')) {
            return back()->withErrors(['folder_name' => 'В названии папки не используйте слэш.'])->withInput();
        }

        $oldPath = SiteDocument::normalizeLinkRoot($site_document->link_root);

        if (! $oldPath) {
            return back()->withErrors(['folder_name' => 'Не удалось определить путь папки.']);
        }

        $parentPath = str_contains($oldPath, '/')
            ? substr($oldPath, 0, (int) strrpos($oldPath, '/'))
            : null;

        $newPath = $parentPath ? $parentPath.'/'.$newSegment : $newSegment;

        if ($newPath === $oldPath) {
            return redirect()
                ->to($this->withSort($site_document->dashboardPageUrl()))
                ->with('status', 'folder-renamed');
        }

        $conflict = SiteDocument::query()
            ->where('title', $site_document->title)
            ->where('link_root', $newPath)
            ->where('id', '!=', $site_document->id)
            ->exists();

        if ($conflict) {
            return back()->withErrors(['folder_name' => 'Папка с таким названием уже есть.'])->withInput();
        }

        $docs = SiteDocument::query()
            ->where('title', $site_document->title)
            ->where(function ($query) use ($oldPath) {
                $query->where('link_root', $oldPath)
                    ->orWhere('link_root', 'like', $oldPath.'/%');
            })
            ->get();

        foreach ($docs as $doc) {
            $current = (string) $doc->link_root;

            if ($current === $oldPath) {
                $doc->update(['link_root' => $newPath]);
            } else {
                $doc->update([
                    'link_root' => $newPath.substr($current, strlen($oldPath)),
                ]);
            }
        }

        $site_document->refresh();

        return redirect()
            ->to($this->withSort($site_document->dashboardPageUrl()))
            ->with('status', 'folder-renamed');
    }

    /** Удалить папку и все вложенные записи (файлы с диска тоже). */
    public function destroyFolder(SiteDocument $site_document): RedirectResponse
    {
        if (! $site_document->link_root) {
            return back()->withErrors(['folder' => 'Эту страницу нельзя удалить как папку.']);
        }

        $folderPath = SiteDocument::normalizeLinkRoot($site_document->link_root);

        if (! $folderPath) {
            return back()->withErrors(['folder' => 'Не удалось определить путь папки.']);
        }

        $parent = $site_document->parentDocument();

        $docs = SiteDocument::query()
            ->where('title', $site_document->title)
            ->where(function ($query) use ($folderPath) {
                $query->where('link_root', $folderPath)
                    ->orWhere('link_root', 'like', $folderPath.'/%');
            })
            ->get();

        foreach ($docs as $doc) {
            $path = $doc->path;

            if (is_string($path) && $path !== '') {
                Storage::disk('public')->delete($path);
            }

            $doc->delete();
        }

        $redirectUrl = $parent
            ? $parent->dashboardPageUrl()
            : route('dashboard.docs.index');

        return redirect()
            ->to($this->withSort($redirectUrl))
            ->with('status', 'folder-deleted');
    }

    public function storeFile(Request $request, SiteDocument $site_document): RedirectResponse
    {
        $validated = $request->validate([
            'file_title' => ['nullable', 'string', 'max:255'],
            'files' => ['required', 'array', 'min:1'],
            'files.*' => ['file', 'max:20480', 'mimes:pdf,jpeg,jpg,png,gif,webp'],
        ], [
            'files.required' => 'Выберите файл документа.',
            'files.*.mimes' => 'Допустимые форматы: PDF, JPEG, JPG, PNG, GIF, WebP.',
            'files.*.max' => 'Каждый файл должен быть не больше 20 МБ.',
        ]);

        $files = $request->file('files');
        $customTitle = trim((string) ($validated['file_title'] ?? ''));

        // Своё название применяем только при одиночной загрузке; для нескольких берём имя каждого файла.
        $useCustomTitle = $customTitle !== '' && count($files) === 1;

        foreach ($files as $file) {
            $path = $file->store('documents', 'public');

            $fileTitle = $useCustomTitle
                ? $customTitle
                : pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

            $fileTitle = trim($fileTitle) !== '' ? trim($fileTitle) : 'Файл';

            if ($site_document->hasFile()) {
                SiteDocument::query()->create([
                    'title' => $site_document->title,
                    'link_root' => $site_document->link_root,
                    'file_title' => $fileTitle,
                    'path' => $path,
                    'sort_order' => (int) SiteDocument::query()->max('sort_order') + 1,
                ]);
            } else {
                $site_document->update([
                    'file_title' => $fileTitle,
                    'path' => $path,
                ]);
                $site_document->refresh();
            }
        }

        return redirect()
            ->to($this->withSort($site_document->dashboardPageUrl()))
            ->with('status', 'file-saved');
    }

    /** Переименовать файл (только отображаемое название). */
    public function renameFile(Request $request, SiteDocument $site_document, SiteDocument $file): RedirectResponse
    {
        $validated = $request->validate([
            'file_title' => ['required', 'string', 'max:255'],
        ], [
            'file_title.required' => 'Укажите название файла.',
        ]);

        $fileTitle = trim($validated['file_title']);

        if ($fileTitle === '') {
            return back()->withErrors(['file_title' => 'Укажите название файла.'])->withInput();
        }

        $file->update(['file_title' => $fileTitle]);

        return redirect()
            ->to($this->withSort($site_document->dashboardPageUrl()))
            ->with('status', 'file-renamed');
    }

    /** Перенести выбранные файлы в другую папку (в том числе в другой документ). */
    public function moveFiles(Request $request, SiteDocument $site_document): RedirectResponse
    {
        $validated = $request->validate([
            'file_ids' => ['required', 'array', 'min:1'],
            'file_ids.*' => ['integer'],
            'target_id' => ['required', 'integer', 'exists:site_documents,id'],
        ], [
            'file_ids.required' => 'Выберите хотя бы один файл.',
            'target_id.required' => 'Выберите папку назначения.',
        ]);

        $target = SiteDocument::query()->findOrFail($validated['target_id']);
        $targetTitle = $target->title;
        $targetRoot = $target->link_root;

        $files = SiteDocument::query()
            ->whereIn('id', $validated['file_ids'])
            ->whereNotNull('path')
            ->get();

        foreach ($files as $file) {
            // Уже в этой папке — пропускаем.
            if ($file->title === $targetTitle && (string) $file->link_root === (string) $targetRoot) {
                continue;
            }

            $siblingsCount = SiteDocument::query()
                ->where('title', $file->title)
                ->where('link_root', $file->link_root)
                ->count();

            // Если запись держит папку/документ (узел ветки) — оставляем узел, создаём новую запись в цели.
            if ($file->id === $site_document->id || $siblingsCount <= 1) {
                SiteDocument::query()->create([
                    'title' => $targetTitle,
                    'link_root' => $targetRoot,
                    'file_title' => $file->file_title,
                    'path' => $file->path,
                    'sort_order' => (int) SiteDocument::query()->max('sort_order') + 1,
                ]);

                $file->update(['file_title' => null, 'path' => null]);
            } else {
                $file->update(['title' => $targetTitle, 'link_root' => $targetRoot]);
            }
        }

        // Чиним иерархию в исходном и целевом документах, чтобы файлы не «повисли».
        SiteDocument::ensureFolderNodes($targetTitle);
        SiteDocument::ensureFolderNodes($site_document->title);

        return redirect()
            ->to($this->withSort($site_document->dashboardPageUrl()))
            ->with('status', 'files-moved');
    }

    /** Сохранить ручной порядок (drag & drop) для документов/папок/файлов. */
    public function reorder(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer'],
            'kind' => ['nullable', 'in:titles,folders,files'],
        ]);

        $kind = $validated['kind'] ?? 'files';

        DB::transaction(function () use ($validated, $kind) {
            foreach (array_values($validated['ids']) as $index => $id) {
                $doc = SiteDocument::query()->find($id);

                if (! $doc) {
                    continue;
                }

                if ($kind === 'titles') {
                    // Двигаем весь документ (все записи с этим title).
                    SiteDocument::query()
                        ->where('title', $doc->title)
                        ->update(['sort_order' => $index]);
                } elseif ($kind === 'folders') {
                    // Двигаем всю группу папки (узел и его файлы), чтобы порядок был стабильным.
                    SiteDocument::query()
                        ->where('title', $doc->title)
                        ->where('link_root', $doc->link_root)
                        ->update(['sort_order' => $index]);
                } else {
                    $doc->update(['sort_order' => $index]);
                }
            }
        });

        return response()->json(['status' => 'ok']);
    }

    /** Удалить файл на текущей ветке (запись-узел не удаляем, только очищаем). */
    public function destroyFile(SiteDocument $site_document, SiteDocument $file): RedirectResponse
    {
        $path = $file->path;

        if (is_string($path) && $path !== '') {
            Storage::disk('public')->delete($path);
        }

        $siblingsCount = SiteDocument::query()
            ->where('title', $file->title)
            ->where('link_root', $file->link_root)
            ->count();

        // Если запись держит документ/папку (узел страницы или единственная в ветке) — очищаем файл, иначе удаляем запись.
        if ($file->id === $site_document->id || $siblingsCount <= 1) {
            $file->update([
                'file_title' => null,
                'path' => null,
            ]);
        } else {
            $file->delete();
        }

        return redirect()
            ->to($this->withSort($site_document->dashboardPageUrl()))
            ->with('status', 'file-deleted');
    }
}
