<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Query\Expression;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->uuid('id');
            $table->timestamps();
            $table->boolean('is_active')->default(true);
            $table->year('last_year_active')->default(new Expression("CURRENT_YEAR"));
            $table->float('total_uc_approveds', 3, 2, true)->default(0);
            $table->uuid('people_id');

            $table->primary('id');
            $table->foreign('people_id')->references('id')->on('people')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
