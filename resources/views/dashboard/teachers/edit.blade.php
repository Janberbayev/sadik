<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex items-start justify-between gap-4 flex-wrap">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Редактирование педагога</h2>
                    <p class="mt-1 text-sm text-gray-600">{{ $teacher->full_name }}</p>
                </div>
                <a href="{{ route('dashboard') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-900">← К dashboard</a>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <form method="post" action="{{ route('dashboard.teachers.update', $teacher) }}" class="space-y-6 max-w-2xl">
                    @csrf
                    @method('patch')

                    <div>
                        <x-input-label for="teacher_edit_full_name" value="ФИ" />
                        <x-text-input id="teacher_edit_full_name" name="full_name" type="text" class="mt-1 block w-full" :value="old('full_name', $teacher->full_name)" required autocomplete="name" />
                        <x-input-error class="mt-2" :messages="$errors->get('full_name')" />
                    </div>

                    <div>
                        <x-input-label for="teacher_edit_position" value="Должность" />
                        <x-text-input id="teacher_edit_position" name="position" type="text" class="mt-1 block w-full" :value="old('position', $teacher->position)" autocomplete="organization-title" />
                        <x-input-error class="mt-2" :messages="$errors->get('position')" />
                    </div>

                    <div>
                        <x-input-label for="teacher_edit_experience" value="Опыт работы" />
                        <textarea id="teacher_edit_experience" name="experience" rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('experience', $teacher->experience) }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('experience')" />
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
