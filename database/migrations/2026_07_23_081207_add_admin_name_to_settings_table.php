<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {

            $table->string('admin_name')->nullable()->after('id');

            $table->boolean('generate_reports')
                  ->default(true)
                  ->after('admin_email');

        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {

            $table->dropColumn([
                'admin_name',
                'generate_reports'
            ]);

        });
    }
};