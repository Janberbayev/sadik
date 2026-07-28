<?php

namespace App\Http\Controllers;

use App\Http\Requests\SiteDocumentStoreRequest;
use App\Models\SiteDocument;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class SiteDocumentController extends Controller
{
    public function store(SiteDocumentStoreRequest $request): RedirectResponse
    {
        $file = $request->file('file');
        $path = $file->store('documents', 'public');
        $sort = (int) SiteDocument::query()->max('sort_order') + 1;

        SiteDocument::query()->create([
            'title' => $request->validated('title'),
            'link_root' => SiteDocument::normalizeLinkRoot($request->validated('link_root')),
            'path' => $path,
            'sort_order' => $sort,
        ]);

        return redirect()->route('dashboard')->with([
            'status' => 'document-saved',
            'saved_section' => 'documents',
        ]);
    }

    public function destroy(SiteDocument $site_document): RedirectResponse
    {
        $path = $site_document->path;

        if (is_string($path) && $path !== '') {
            Storage::disk('public')->delete($path);
        }

        $site_document->delete();

        return redirect()->route('dashboard')->with([
            'status' => 'document-deleted',
            'saved_section' => 'documents',
        ]);
    }
}
