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
        Schema::create('scans', function (Blueprint $table) {
            $table->id();
            $table->string('website');
            $table->string('base_url');
            $table->string('host');

            $table->longText('to_visit');
            $table->longText('visited');
            $table->longText('broken_links');

            $table->integer('indexed')->default(0);
            $table->integer('broken')->default(0);
            $table->integer('skipped')->default(0);

            $table->boolean('finished')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scans');
    }
};
