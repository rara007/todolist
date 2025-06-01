<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id(); // Ini adalah kolom ID utama (primary key)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign Key ke tabel 'users', jika user dihapus tugasnya juga dihapus
            $table->string('title'); // Kolom untuk judul tugas (teks singkat)
            $table->text('description')->nullable(); // Kolom untuk deskripsi tugas (teks panjang), boleh kosong
            $table->boolean('completed')->default(false); // Kolom boolean (true/false) untuk status selesai, defaultnya false
            $table->date('due_date')->nullable(); // Kolom untuk tanggal jatuh tempo, boleh kosong
            $table->timestamps(); // Ini otomatis membuat kolom 'created_at' dan 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     * Digunakan saat melakukan rollback migrasi (misal: php artisan migrate:rollback)
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks'); // Hapus tabel 'tasks' jika migrasi di-rollback
    }
};