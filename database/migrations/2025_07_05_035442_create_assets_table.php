<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsTable extends Migration
{
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('name', 191);
            $table->string('asset_tag', 191)->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->string('serial', 191)->nullable();
            $table->date('purchase_date')->nullable();
            $table->date('asset_eol_date')->nullable();
            $table->boolean('eol_explicit')->default(0);
            $table->decimal('purchase_cost', 20, 2)->nullable();
            $table->string('order_number', 191)->nullable();
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->text('notes')->nullable();
            $table->text('image')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->boolean('physical')->default(1);
            $table->unsignedBigInteger('status_id')->nullable();
            $table->boolean('archived')->default(0);
            $table->integer('warranty_months')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->boolean('requestable')->default(0);
            $table->unsignedBigInteger('rtd_location_id')->nullable();
            $table->string('snippet_mac_address_1', 191)->nullable();
            $table->boolean('accepted')->default(0);
            $table->dateTime('last_checkout')->nullable();
            $table->dateTime('last_checkin')->nullable();
            $table->dateTime('expected_checkin_date')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
}
