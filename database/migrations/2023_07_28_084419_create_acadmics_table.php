<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcadmicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acadmics', function (Blueprint $table) {
            $table->id();
            $table->string('student_id')->unique();
            $table->string('center_code')->unique();
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('gender');
            $table->string('category');
            $table->string('employment_status');
            $table->string('adhar_number');
            $table->string('signature');
            $table->string('photo');
            $table->string('pincode');
            $table->string('city');
            $table->string('distric');
            $table->string('state');
            $table->string('nationality');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acadmics');
    }
}
