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
        Schema::create('user_satisfaction_response_values', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_satisfaction_response_id');
            $table->foreign('user_satisfaction_response_id', 'FK_response_id_on_user_satisfaction_responses')
                    ->references('id')
                    ->on('user_satisfaction_responses')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->uuid('user_satisfaction_indicator_id');
            $table->foreign('user_satisfaction_indicator_id', 'FK_indicator_id_on_user_satisfaction_indicators')
                    ->references('id')
                    ->on('user_satisfaction_indicators')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->uuid('user_satisfaction_option_id');
            $table->foreign('user_satisfaction_option_id', 'FK_option_id_on_user_satisfaction_options')
                    ->references('id')
                    ->on('user_satisfaction_options')
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
        Schema::dropIfExists('user_satisfaction_response_values');
    }
};
