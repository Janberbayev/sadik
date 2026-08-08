<x-guest-layout>
    <div class="text-center">
        <div class="mx-auto mb-4 flex items-center justify-center rounded-full bg-amber-100" style="width:64px;height:64px;font-size:1.8rem;">⏳</div>

        <h2 class="text-lg font-semibold text-gray-800">
            Заявка отправлена
        </h2>

        <p class="mt-3 text-sm leading-relaxed text-gray-600">
            Ваш аккаунт создан и ожидает проверки. Администратор рассмотрит заявку
            и одобрит доступ. После одобрения вы сможете войти со своими логином и паролем.
        </p>

        <a href="{{ route('login') }}"
           class="mt-6 inline-flex items-center justify-center rounded-md bg-gray-800 px-4 py-2 text-sm font-semibold text-white transition hover:bg-gray-700">
            Перейти ко входу
        </a>
    </div>
</x-guest-layout>
