<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_groups', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            /** group == section */
            $table->string('group', 9)->index();
            $table->integer('max_quotas', false, true)->default(1);
            $table->uuid('period_id');
            $table->uuid('pensum_id');
            $table->nullableUuidMorphs('teacher');

            $table
                ->foreign('pensum_id')
                ->references('id')
                ->on('pensums')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table
                ->foreign('period_id')
                ->references('id')
                ->on('periods')
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
        Schema::dropIfExists('student_groups');
    }
}
