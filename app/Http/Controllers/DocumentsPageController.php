<?php

namespace App\Http\Controllers;

use App\Models\SiteDocument;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DocumentsPageController extends Controller
{
    public function index(): View
    {
        $documents = SiteDocument::query()
            ->ordered()
            ->get()
            ->unique('title')
            ->values();

        return view('documents', [
            'documents' => $documents,
        ]);
    }

    /** Создать новое «Название документа» — попадает в список и в меню. */
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

        $sort = (int) SiteDocument::query()->max('sort_order') + 1;

        SiteDocument::query()->create([
            'title' => $title,
            'link_root' => null,
            'path' => null,
            'sort_order' => $sort,
        ]);

        return redirect()
            ->to(locale_route('documents.index'))
            ->with('status', 'title-created');
    }

    /** Страница «Название документа»: список папок/файлов + формы. */
    public function show(SiteDocument $site_document): View
    {
        return view('documents.show', [
            'document' => $site_document,
            'folders' => $site_document->childFolders(),
            'files' => $site_document->folderFiles(),
        ]);
    }

    /** Страница папки: вложенные папки, файлы и те же формы. */
    public function folder(SiteDocument $site_document): View|RedirectResponse
    {
        if (! $site_document->link_root) {
            return redirect()->to(locale_route('documents.show', ['site_document' => $site_document]));
        }

        $parent = $site_document->parentDocument() ?: $site_document;

        return view('documents.folder', [
            'document' => $site_document,
            'parent' => $parent,
            'folders' => $site_document->childFolders(),
            'files' => $site_document->folderFiles(),
        ]);
    }

    /** Создать папку (внутри текущей, если уже в папке). */
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

        $sort = (int) SiteDocument::query()->max('sort_order') + 1;

        SiteDocument::query()->create([
            'title' => $site_document->title,
            'link_root' => $folderName,
            'path' => null,
            'sort_order' => $sort,
        ]);

        return redirect()
            ->to($site_document->publicPageUrl())
            ->with('status', 'folder-created');
    }

    /** Сохранить файл (название + файл) в текущую ветку. */
    public function storeFile(Request $request, SiteDocument $site_document): RedirectResponse
    {
        $validated = $request->validate([
            'file_title' => ['required', 'string', 'max:255'],
            'file' => ['required', 'file', 'max:15360', 'mimes:pdf,jpeg,jpg,png,gif,webp'],
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
            ->to($site_document->publicPageUrl())
            ->with('status', 'file-saved');
    }
}
