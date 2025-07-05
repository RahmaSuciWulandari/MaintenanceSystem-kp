<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelsTable extends Migration
{
    public function up(): void
    {
        Schema::create('models', function (Blueprint $table) {
            $table->id();
            $table->string('name', 191);
            $table->string('model_number', 191)->nullable();
            $table->integer('min_amt')->nullable();
            $table->unsignedBigInteger('manufacturer_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('depreciation_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->string('image', 191)->nullable();
            $table->boolean('deprecated_mac_address')->default(0);
            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('fieldset_id')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('requestable')->default(0);
            $table->timestamps();

            // Optional foreign keys (if needed)
            // $table->foreign('manufacturer_id')->references('id')->on('manufacturers');
            // $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('models');
    }
}
