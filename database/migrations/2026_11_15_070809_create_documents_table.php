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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            // Foreign Key ភ្ជាប់ទៅកាន់ table categories
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('title'); // ចំណងជើងឯកសារ
            $table->string('file_path'); // ទីតាំងផ្ទុក File នៅក្នុង storage
            $table->string('file_type', 20)->nullable(); // កន្ទុយ File (pdf, docx, pptx, xlsx, etc.)
            $table->string('file_size')->nullable(); // ទំហំ File (KB, MB)
            $table->string('academic_year', 20); // ឆ្នាំសិក្សា (ឧ. 2024-2025)
            $table->text('description')->nullable(); // បរិយាយបន្ថែមអំពីឯកសារ
            $table->boolean('is_portfolio')->default(false); // កំណត់ថាជាឯកសារ Portfolio ឬអត់
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
