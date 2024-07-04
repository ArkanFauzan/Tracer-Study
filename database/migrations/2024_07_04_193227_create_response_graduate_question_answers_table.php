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
        Schema::create('response_graduate_question_answers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('response_graduate_question_id');
            $table->foreign('response_graduate_question_id', 'res_grad_ques_ans_question_id_foreign')
                    ->references('id')
                    ->on('response_graduate_questions')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->foreignUuid('question_option_id')
                    ->references('id')
                    ->on('question_options')
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
        Schema::dropIfExists('response_graduate_question_answers');
    }
};
