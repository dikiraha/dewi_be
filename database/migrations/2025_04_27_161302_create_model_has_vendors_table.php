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
        Schema::create('model_has_vendors', function (Blueprint $table) {
            $table->unsignedBigInteger('model_id');
            $table->unsignedBigInteger('vendor_id');

            $table->primary(['model_id', 'vendor_id']);

            $table->foreign('model_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('vendor_id')
                ->references('id')
                ->on('vendors')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_has_vendors');
    }
};
