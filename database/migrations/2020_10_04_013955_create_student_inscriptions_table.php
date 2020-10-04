<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentInscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_inscriptions', function (Blueprint $table) {
            $table->uuid('id');
            $table->timestamps();
            $table->softDeletes();
            $table->uuid('student_id');
            $table->uuid('period_id');
            $table->float('period_avg', 3,2, true)->default(0.00);

            $table->primary('id');
            $table
                ->foreign('student_id')
                ->references('id')
                ->on('students')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table
                ->foreign('period_id')
                ->references('id')
                ->on('periods')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_inscriptions');
    }
}
