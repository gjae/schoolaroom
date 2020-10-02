<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->uuid('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('first_name', 40);
            $table->string('last_name', 50);
            $table->string('document_type',4 )->index();
            $table->string('civil_state', 20)->default('SOLTERO/A');
            $table->string('document_id', 30)->unique();
            $table->enum('sex', ['M', 'F', 'O']);
            $table->string('email', 70)->unique();
            $table->date('birthday_at');
            $table->foreignId('country_id')->constrained();
            $table->foreignId('state_id')->constrained();

            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('people');
    }
}
