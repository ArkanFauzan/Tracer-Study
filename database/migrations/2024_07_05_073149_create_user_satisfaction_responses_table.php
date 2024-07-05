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
        Schema::create('user_satisfaction_responses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('tracer_id')
                    ->references('id')
                    ->on('tracers')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->foreignUuid('major_id')
                    ->references('id')
                    ->on('majors')
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
        Schema::dropIfExists('user_satisfaction_responses');
    }
};
