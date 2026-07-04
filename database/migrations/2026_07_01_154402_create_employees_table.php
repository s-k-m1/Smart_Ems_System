<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id')->unique(); // e.g. EMP-1024
            $table->string('name');
            $table->string('department');
            $table->string('position');
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->string('email')->unique();
            $table->string('phone');
            $table->date('joined');
            $table->string('address');
            $table->string('image')->nullable();
            $table->unsignedInteger('present_days')->default(0);
            $table->unsignedInteger('leave_taken')->default(0);
            $table->decimal('salary', 10, 2)->default(0);
            $table->unsignedInteger('projects')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};