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
        Schema::create('chirps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // ID pengguna yang membuat chirp
            $table->string('message'); // Pesan dari pengguna
            $table->string('image')->nullable(); // URL gambar, jika ada
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chirps');
    }
};
