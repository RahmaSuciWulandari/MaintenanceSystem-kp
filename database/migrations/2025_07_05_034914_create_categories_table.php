<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->longText('eula_text')->nullable();
            $table->boolean('use_default_eula')->default(0);
            $table->boolean('require_acceptance')->default(0);
            $table->string('category_type', 191)->nullable();
            $table->boolean('checkin_email')->default(0);
            $table->string('image', 191)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
}
