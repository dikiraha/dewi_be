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
        Schema::create('purchase_requisitions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('no_reg', 20)->unique();
            $table->string('title');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('department_id')->constrained('departments');
            $table->text('description')->nullable();
            $table->enum('status', ['Created', 'Approved by Manager', 'Rejected by Manager', 'Process by Purchasing', 'Rejected by Purchasing', 'Purchase Order', 'Finished'])->default('Created');
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_requisitions');
    }
};
