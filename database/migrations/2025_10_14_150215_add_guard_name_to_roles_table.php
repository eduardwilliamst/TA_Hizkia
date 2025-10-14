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
        Schema::table('roles', function (Blueprint $table) {
            // Add guard_name column
            $table->string('guard_name')->default('web')->after('name');

            // Remove deleted_at if exists (Spatie doesn't use soft deletes)
            if (Schema::hasColumn('roles', 'deleted_at')) {
                $table->dropColumn('deleted_at');
            }

            // Add unique constraint for name and guard_name
            $table->unique(['name', 'guard_name']);
        });

        // Update existing records to have guard_name
        \DB::table('roles')->update(['guard_name' => 'web']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            // Drop unique constraint
            $table->dropUnique(['name', 'guard_name']);

            // Drop guard_name column
            $table->dropColumn('guard_name');

            // Add back deleted_at
            $table->softDeletes();
        });
    }
};
