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
        Schema::create('response_graduate_questions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->longText('answer')->nullable();
            $table->foreignUuid('response_graduate_id')
                    ->references('id')
                    ->on('response_graduates')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->foreignUuid('question_id')
                    ->references('id')
                    ->on('questions')
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
        Schema::dropIfExists('response_graduate_questions');
    }
};
