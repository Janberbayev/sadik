<?php

return [
    /*
    | Пароль для доступа к разделу «Документы» на публичном сайте.
    | Меняется через переменную окружения DOCUMENTS_PASSWORD в файле .env.
    | Если пусто — раздел открыт без пароля.
    */
    'documents_password' => env('DOCUMENTS_PASSWORD', ''),
];
