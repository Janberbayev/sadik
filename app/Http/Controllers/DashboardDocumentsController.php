<?php

namespace App\Http\Controllers;

use App\Models\SiteDocument;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class DashboardDocumentsController extends Controller
{
    public function index(): View
    {
        $documents = SiteDocument::query()
            ->ordered()
            ->get()
            ->unique('title')
            ->values();

        return view('dashboard.documents.index', [
            'documents' => $documents,
        ]);
    }

    public function show(SiteDocument $site_document): View
    {
        return view('dashboard.documents.show', [
            'document' => $site_document,
            'folders' => $site_document->childFolders(),
            'files' => $site_document->folderFiles(),
        ]);
    }

    public function folder(SiteDocument $site_document): View|RedirectResponse
    {
        if (! $site_document->link_root) {
            return redirect()->route('dashboard.docs.show', $site_document);
        }

        $parent = $site_document->parentDocument() ?: $site_document;

        return view('dashboard.documents.folder', [
            'document' => $site_document,
            'parent' => $parent,
            'folders' => $site_document->childFolders(),
            'files' => $site_document->folderFiles(),
        ]);
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
            ->to($site_document->dashboardPageUrl())
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
                ->to($site_document->dashboardPageUrl())
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
            ->to($site_document->dashboardPageUrl())
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
            ->to($redirectUrl)
            ->with('status', 'folder-deleted');
    }

    public function storeFile(Request $request, SiteDocument $site_document): RedirectResponse
    {
        $validated = $request->validate([
            'file_title' => ['required', 'string', 'max:255'],
            'file' => ['required', 'file', 'max:20480', 'mimes:pdf,jpeg,jpg,png,gif,webp'],
        ], [
            'file_title.required' => 'Укажите название файла.',
            'file.required' => 'Выберите файл документа.',
            'file.mimes' => 'Допустимые форматы: PDF, JPEG, JPG, PNG, GIF, WebP.',
        ]);

        $path = $request->file('file')->store('documents', 'public');
        $fileTitle = trim($validated['file_title']);

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
        }

        return redirect()
            ->to($site_document->dashboardPageUrl())
            ->with('status', 'file-saved');
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
            ->to($site_document->dashboardPageUrl())
            ->with('status', 'file-deleted');
    }
}
