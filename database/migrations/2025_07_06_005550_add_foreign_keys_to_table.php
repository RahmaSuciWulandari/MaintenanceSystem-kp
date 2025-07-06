<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToTable extends Migration
{
    public function up(): void
    {
        // locations
        Schema::table('locations', function (Blueprint $table) {
            $table->foreign('manager_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('parent_id')->references('id')->on('locations')->nullOnDelete();
        });

        // models
        Schema::table('models', function (Blueprint $table) {
            $table->foreign('manufacturer_id')->references('id')->on('manufacturers')->nullOnDelete();
            $table->foreign('category_id')->references('id')->on('categories')->nullOnDelete();
            //$table->foreign('depreciation_id')->references('id')->on('depreciations')->nullOnDelete();
            //$table->foreign('fieldset_id')->references('id')->on('fieldsets')->nullOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
        });

        // assets
        Schema::table('assets', function (Blueprint $table) {
            $table->foreign('model_id')->references('id')->on('models')->nullOnDelete();
            $table->foreign('status_id')->references('id')->on('status_labels')->nullOnDelete();
            $table->foreign('assigned_to')->references('id')->on('users')->nullOnDelete();
            $table->foreign('supplier_id')->references('id')->on('manufacturers')->nullOnDelete();
            $table->foreign('rtd_location_id')->references('id')->on('locations')->nullOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
        });

        // users
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('manager_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('location_id')->references('id')->on('locations')->nullOnDelete();
            //$table->foreign('company_id')->references('id')->on('companies')->nullOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            //$table->foreign('role_id')->references('id')->on('roles')->nullOnDelete();
        });

        // users_groups (pivot)
        Schema::table('users_groups', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('permission_groups')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
        });

        // status_labels
        Schema::table('status_labels', function (Blueprint $table) {
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
        });

        // permission_groups
        Schema::table('permission_groups', function (Blueprint $table) {
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        // Drop foreign keys in reverse order
        Schema::table('permission_groups', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
        });

        Schema::table('status_labels', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
        });

        Schema::table('users_groups', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['group_id']);
            $table->dropForeign(['created_by']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['manager_id']);
            $table->dropForeign(['location_id']);
            //$table->dropForeign(['company_id']);
            $table->dropForeign(['created_by']);
            $table->dropForeign(['role_id']);
        });

        Schema::table('assets', function (Blueprint $table) {
            $table->dropForeign(['model_id']);
            $table->dropForeign(['status_id']);
            $table->dropForeign(['assigned_to']);
            $table->dropForeign(['supplier_id']);
            $table->dropForeign(['rtd_location_id']);
            $table->dropForeign(['created_by']);
        });

        Schema::table('models', function (Blueprint $table) {
            $table->dropForeign(['manufacturer_id']);
            $table->dropForeign(['category_id']);
            $table->dropForeign(['depreciation_id']);
            $table->dropForeign(['fieldset_id']);
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
        });

        Schema::table('locations', function (Blueprint $table) {
            $table->dropForeign(['manager_id']);
            $table->dropForeign(['parent_id']);
        });
    }
}
