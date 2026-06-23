<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('company_settings', function (Blueprint $table) {

            $table->id();

            $table->integer('monthly_working_hours')->default(205);

            $table->integer('annual_leave_days')->default(12);

            $table->string('weekly_holiday')->default('Saturday');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_settings');
    }
};