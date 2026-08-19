<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_scans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->string('website');
            $table->string('base_url');
            $table->string('host');

            $table->json('to_visit')->nullable();
            $table->json('visited')->nullable();
            $table->json('broken_links')->nullable();

            $table->integer('indexed')->default(0);
            $table->integer('broken')->default(0);
            $table->integer('skipped')->default(0);

            $table->boolean('finished')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_scans');
    }
};