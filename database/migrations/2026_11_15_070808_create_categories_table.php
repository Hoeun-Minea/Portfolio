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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // ឈ្មោះប្រភេទ (ឧ. កិច្ចតែងការ, ស្លាយបង្រៀន, ស្នាដៃ...)
            $table->string('slug')->unique(); // ស្លាក់សម្រាប់ URL
            $table->text('description')->nullable(); // ការពណ៌នា
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
