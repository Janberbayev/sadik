<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex items-start justify-between gap-4 flex-wrap">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Редактирование группы</h2>
                    <p class="mt-1 text-sm text-gray-600">{{ \Illuminate\Support\Str::limit($group->title, 80) }}</p>
                </div>
                <a href="{{ route('dashboard') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-900">← К dashboard</a>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <form method="post" action="{{ route('dashboard.program-groups.update', $group) }}" enctype="multipart/form-data" class="space-y-6 max-w-2xl">
                    @csrf
                    @method('patch')

                    <div>
                        <x-input-label for="pg_edit_title" value="Название" />
                        <textarea id="pg_edit_title" name="title" rows="3" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('title', $group->title) }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        <p class="mt-1 text-xs text-gray-500">Первая строка — название группы, вторая — возраст (по желанию).</p>
                    </div>

                    <div>
                        <x-input-label for="pg_edit_image" value="Картинка группы" />
                        @if ($group->hasImage())
                            <div class="mt-2 mb-3">
                                <img src="{{ $group->assetUrl() }}" alt="" class="rounded-lg border border-gray-200 object-cover" width="80" height="80">
                            </div>
                        @endif
                        <input id="pg_edit_image" type="file" name="image" accept="image/*"
                            class="mt-1 block w-full text-sm text-gray-600 file:me-4 file:rounded-md file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-xs file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100 @error('image') border-red-500 @enderror" />
                        <x-input-error class="mt-2" :messages="$errors->get('image')" />
                        <p class="mt-1 text-xs text-gray-500">Необязательно. До 5 МБ. При загрузке нового файла предыдущий будет заменён.</p>
                    </div>

                    <div>
                        <x-input-label for="pg_edit_items" value="Список программ" />
                        <textarea id="pg_edit_items" name="items_raw" rows="10"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('items_raw', implode("\n", $group->bulletItems())) }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('items_raw')" />
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
