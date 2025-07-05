<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name', 191);
            $table->string('city', 191)->nullable();
            $table->string('state', 191)->nullable();
            $table->string('country', 191)->nullable();
            $table->string('address', 191)->nullable();
            $table->string('address2', 191)->nullable();
            $table->string('zip', 10)->nullable();
            $table->string('fax', 20)->nullable();
            $table->string('phone', 20)->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('currency', 10)->nullable();
            $table->string('ldap_ou', 191)->nullable();
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->string('image', 191)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
}
