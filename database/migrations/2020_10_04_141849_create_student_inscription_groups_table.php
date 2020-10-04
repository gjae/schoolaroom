<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentInscriptionGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_inscription_groups', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->uuid('student_inscription_id');
            $table->float('group_avg', 3,2)->default(0.00);
            $table->foreignId('student_group_id')->constrained('student_groups', 'id');
            $table->foreignId('group_horary_matter_id')->constrained('group_horary_matters');
            

            $table
                ->foreign('student_inscription_id')
                ->references('id')
                ->on('student_inscriptions')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_inscription_groups');
    }
}
