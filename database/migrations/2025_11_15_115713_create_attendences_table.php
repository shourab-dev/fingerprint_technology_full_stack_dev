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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->timestamp('date');
            $table->enum('status', ['present', 'absent', 'late']);
            $table->string('note')->nullable();
            $table->string('recorded_by');
            $table->timestamps();
            $table->unique(['student_id', 'date']);
            $table->index(['date', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendences');
    }
};
