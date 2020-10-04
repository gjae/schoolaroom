<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periods', function (Blueprint $table) {
            $table->uuid('id');
            $table->timestamps();
            $table->softDeletes();
            $table->uuid('degree_id');
            $table->uuid('pensum_id');
            $table->string('period_description', 140);
            $table->boolean('is_special')->default(false);
            $table->dateTime('period_opened_at')->useCurrent();
            $table->dateTime('period_closed_at')->nullable();

            $table->primary('id');
            $table
                ->foreign('pensum_id')
                ->references('id')
                ->on('pensums')
                ->onDelete('restrict');
            $table
                ->foreign('degree_id')
                ->references('id')
                ->on('degrees')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('periods');
    }
}
