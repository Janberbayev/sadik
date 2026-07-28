<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex items-start justify-between gap-4 flex-wrap">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Галерея — редактирование</h2>
                    <p class="mt-1 text-sm text-gray-600">{{ $item->path }}</p>
                </div>
                <a href="{{ route('dashboard') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-900">← К dashboard</a>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="mb-6 overflow-hidden rounded-lg ring-1 ring-gray-200 max-w-[11rem] shadow-sm">
                    <img src="{{ $item->assetUrl() }}" alt="" class="aspect-[4/3] w-full max-h-36 object-cover">
                </div>

                <form method="post" action="{{ route('dashboard.gallery-items.update', $item) }}" enctype="multipart/form-data" class="space-y-6 max-w-2xl">
                    @csrf
                    @method('patch')

                    <div>
                        <x-input-label for="gallery_image_replace" value="Новое изображение (необязательно)" />
                        <input id="gallery_image_replace" type="file" name="image" accept="image/*" class="mt-1 block w-full text-sm text-gray-600 file:me-4 file:rounded-md file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-xs file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100" />
                        <x-input-error class="mt-2" :messages="$errors->get('image')" />
                        <p class="mt-1 text-xs text-gray-500">Если выбрать файл, старое изображение будет удалено с сервера.</p>
                    </div>

                    <div>
                        <x-input-label for="gallery_caption_edit" value="Подпись" />
                        <x-text-input id="gallery_caption_edit" name="caption" type="text" class="mt-1 block w-full" :value="old('caption', $item->caption)" maxlength="500" />
                        <x-input-error class="mt-2" :messages="$errors->get('caption')" />
                    </div>

                    <div class="flex gap-4">
                        <x-primary-button type="submit">Сохранить</x-primary-button>
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm hover:bg-gray-50">Отмена</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
