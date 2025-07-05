<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email', 191)->unique();
            $table->string('password', 191);
            $table->text('permissions')->nullable();
            $table->boolean('activated')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamp('activated_at')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->string('persist_code', 191)->nullable();
            $table->string('reset_password_code', 191)->nullable();
            $table->string('first_name', 191)->nullable();
            $table->string('last_name', 191)->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->string('work_email', 191)->nullable();
            $table->string('country', 191)->nullable();
            $table->string('gravatar', 191)->nullable();
            $table->string('jobtitle', 191)->nullable();
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->string('employee_num', 191)->nullable();
            $table->string('username', 191)->unique();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->string('remember_token', 100)->nullable();
            $table->boolean('ldap_import')->default(0);
            $table->unsignedBigInteger('location_id')->nullable();
            $table->string('avatar', 191)->nullable();
            $table->timestamps();
            $table->text('notes')->nullable();
            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
}
