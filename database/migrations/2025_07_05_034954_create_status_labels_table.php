<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusLabelsTable extends Migration
{
    public function up(): void
    {
        Schema::create('status_labels', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->boolean('deployable')->default(0);
            $table->boolean('pending')->default(0);
            $table->boolean('archived')->default(0);
            $table->text('notes')->nullable();
            $table->string('color', 10)->nullable();
            $table->boolean('show_in_nav')->default(1);
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('status_labels');
    }
}
