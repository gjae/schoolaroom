<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePensumHasSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pensum_has_subjects', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->uuid('pensum_id');
            $table->uuidMorphs('assignable');
            $table->nullableUuidMorphs('assignable_prelation');

            $table
                ->foreign('pensum_id')
                ->references('id')
                ->on('pensums')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pensum_has_subjects');
    }
}
