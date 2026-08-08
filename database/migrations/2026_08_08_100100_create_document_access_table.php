<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Логин и пароль для доступа посетителей к разделу «Документы».
     * Одна строка-синглтон, редактируется админом в панели.
     */
    public function up(): void
    {
        Schema::create('document_access', function (Blueprint $table) {
            $table->id();
            $table->string('login')->nullable();
            $table->string('password')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_access');
    }
};
