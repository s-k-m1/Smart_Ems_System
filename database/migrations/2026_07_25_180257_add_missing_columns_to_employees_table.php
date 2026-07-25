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
        Schema::table('employees', function (Blueprint $table) {
            $table->string('position')->nullable()->after('department');
            $table->string('status')->default('Active')->after('position');
            $table->date('joined')->nullable()->after('status');
            $table->string('address')->nullable()->after('joined');
            $table->string('image')->nullable()->after('address');
            $table->integer('present_days')->default(0)->after('image');
            $table->integer('leave_taken')->default(0)->after('present_days');
            $table->decimal('salary', 10, 2)->default(0)->after('leave_taken');
            $table->integer('projects')->default(0)->after('salary');
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn(['position', 'status', 'joined', 'address', 'image', 'present_days', 'leave_taken', 'salary', 'projects']);
        });
    }
};
