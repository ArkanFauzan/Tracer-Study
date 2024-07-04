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
        Schema::create('questions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('question');
            $table->foreignUuid('question_section_id')
                    ->references('id')
                    ->on('question_sections')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->foreignUuid('question_type_id')
                    ->references('id')
                    ->on('question_types')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
