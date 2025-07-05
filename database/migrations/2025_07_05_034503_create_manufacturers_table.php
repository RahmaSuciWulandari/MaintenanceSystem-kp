<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManufacturersTable extends Migration
{
    public function up(): void
    {
        Schema::create('manufacturers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 191);
            $table->string('url', 191)->nullable();
            $table->string('support_url', 191)->nullable();
            $table->string('warranty_lookup_url', 191)->nullable();
            $table->string('support_phone', 191)->nullable();
            $table->string('support_email', 191)->nullable();
            $table->string('image', 191)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('manufacturers');
    }
}
