<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Attendance', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid("Employee_id")
                ->index()
                ->constrained('Employee')
                ->onDelete('cascade'); // if the employee deleted, the attendance that associate with employee, should be deleted 

            $table->dateTime("Time_in");
            $table->dateTime("Time_out")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Attendance');
    }
}
