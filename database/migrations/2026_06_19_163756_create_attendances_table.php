<?php

use Illuminate\Database\Migrations\Migration;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {

        Schema::create(

            'attendances',

            function (Blueprint $table) {

                $table->id();

                $table
                ->foreignId(
                    'employee_id'
                )
                ->constrained(
                    'employees'
                )
                ->cascadeOnDelete();


                $table
                ->enum(
                    'status',
                    [
                        'Present',
                        'Late',
                        'Undertime',
                        'Absent'
                    ]
                );


                $table
                ->date(
                    'date'
                );


                $table
                ->time(
                    'check_in'
                )
                ->nullable();



                $table
                ->time(
                    'check_out'
                )
                ->nullable();


                $table
                ->timestamps();
            }
        );
    }


    public function down()
    {
        Schema::dropIfExists(
            'attendances'
        );
    }
};