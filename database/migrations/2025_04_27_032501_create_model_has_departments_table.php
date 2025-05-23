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
        Schema::create('model_has_departments', function (Blueprint $table) {
            $table->unsignedBigInteger('model_id');
            $table->unsignedBigInteger('department_id');

            $table->primary(['model_id', 'department_id']);

            $table->foreign('model_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('department_id')
                ->references('id')
                ->on('departments')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_has_departments');
    }
};
