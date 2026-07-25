<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {

            $table->id();

            $table->string('title');

            $table->text('description');

            $table->string('category');

            $table->string('department')->nullable();

            $table->string('priority', 10)->default('Medium');

            $table->boolean('is_pinned')->default(false);

            $table->string('published_by');

            $table->dateTime('publish_date');

            $table->string('attachment')->nullable();

            $table->boolean('status')->default(true);

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};