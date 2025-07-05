<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersGroupsTable extends Migration
{
    public function up(): void
    {
        Schema::create('users_groups', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('created_by')->nullable();

            $table->primary(['user_id', 'group_id']); // Composite primary key
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users_groups');
    }
}
