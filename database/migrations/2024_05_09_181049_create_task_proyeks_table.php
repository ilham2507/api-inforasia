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
        Schema::create('task_proyeks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyek_id')->references('id')->on('proyeks')->onDelete('cascade');
            $table->string('tugas')->nullable();
            $table->longText('catatan')->nullable();
            $table->string('pekerja')->nullable();
            $table->date('start')->nullable();
            $table->date('deadline')->nullable();
            $table->string('status')->nullable();
            $table->integer('nilai')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_proyeks');
    }
};
