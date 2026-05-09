<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Employee', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('NIK', 13)->unique();
            $table->string('Full_name', 50);
            $table->foreignUuid("Dept_id")
                ->index()
                ->constrained("Department");

            $table->string("Designation", 50)->nullable();
            $table->enum("Gender", ["Male", "Female"]);
            $table->string("Birth_place", 50);
            $table->date("Birth_date");
            $table->string("Phone_no", 13);
            $table->date("Join_date");
            $table->date("Join_end")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Employee');
    }
}
