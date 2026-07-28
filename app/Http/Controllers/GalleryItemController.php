<?php

namespace App\Http\Controllers;

use App\Http\Requests\GalleryItemBulkDestroyRequest;
use App\Http\Requests\GalleryItemStoreRequest;
use App\Http\Requests\GalleryItemUpdateRequest;
use App\Models\GalleryItem;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class GalleryItemController extends Controller
{
    public function edit(GalleryItem $gallery_item): View
    {
        return view('dashboard.gallery-items.edit', [
            'item' => $gallery_item,
        ]);
    }

    public function store(GalleryItemStoreRequest $request): RedirectResponse
    {
        $caption = $request->validated('caption');
        $sort = (int) GalleryItem::query()->max('sort_order') + 1;
        $files = $request->file('images', []);
        $uploaded = 0;

        foreach ($files as $file) {
            if ($file === null || ! $file->isValid()) {
                continue;
            }
            $path = $file->store('gallery', 'public');
            GalleryItem::query()->create([
                'path' => $path,
                'caption' => $caption,
                'sort_order' => $sort,
            ]);
            $sort++;
            $uploaded++;
        }

        if ($uploaded === 0) {
            return redirect()->route('dashboard')->withErrors([
                'images' => 'Не удалось сохранить файлы. Проверьте формат и размер (до 5 МБ каждый).',
            ])->withInput();
        }

        return redirect()->route('dashboard')->with([
            'status' => 'gallery-saved',
            'saved_section' => 'gallery',
            'gallery_upload_count' => $uploaded,
        ]);
    }

    public function update(GalleryItemUpdateRequest $request, GalleryItem $gallery_item): RedirectResponse
    {
        $data = [
            'caption' => $request->validated('caption'),
        ];

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($gallery_item->path);
            $data['path'] = $request->file('image')->store('gallery', 'public');
        }

        $gallery_item->update($data);

        return redirect()->route('dashboard')->with([
            'status' => 'gallery-saved',
            'saved_section' => 'gallery',
        ]);
    }

    public function destroy(GalleryItem $gallery_item): RedirectResponse
    {
        Storage::disk('public')->delete($gallery_item->path);
        $gallery_item->delete();

        return redirect()->route('dashboard')->with([
            'status' => 'gallery-deleted',
            'saved_section' => 'gallery',
        ]);
    }

    public function bulkDestroy(GalleryItemBulkDestroyRequest $request): RedirectResponse
    {
        $items = GalleryItem::query()->whereIn('id', $request->validated('ids'))->get();
        foreach ($items as $item) {
            Storage::disk('public')->delete($item->path);
            $item->delete();
        }

        return redirect()->route('dashboard')->with([
            'status' => 'gallery-deleted',
            'saved_section' => 'gallery',
            'gallery_bulk_deleted_count' => $items->count(),
        ]);
    }
}
