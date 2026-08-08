<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Регистрация теперь проходит модерацию: новые пользователи получают статус
     * «pending», пока админ не одобрит. Существующие аккаунты сразу «approved».
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('password');
        });

        // Все уже созданные аккаунты считаем одобренными, чтобы сайт не заблокировался.
        DB::table('users')->update(['status' => 'approved']);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
