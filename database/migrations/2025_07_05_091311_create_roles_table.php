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
        Schema::create('roles', function (Blueprint $table) {
    $table->id();
    $table->string('name')->unique(); // e.g., 'admin', 'pic_unit', 'pelaksana', 'manager_it'
    $table->string('display_name')->nullable(); // e.g., 'Admin', 'PIC Unit'
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
