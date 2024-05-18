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
        Schema::table('task_proyeks', function (Blueprint $table) {
            $table->dropForeign('task_proyeks_proyek_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('task_proyeks', function (Blueprint $table) {
            $table->foreign('proyek_id')->references('id')->on('proyeks');
        });
    }
};
