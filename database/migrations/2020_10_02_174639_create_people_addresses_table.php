<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people_addresses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('zip_code', 8)->index();
            $table->string('city', 70);
            $table->string('mobile_phone', 15);
            $table->string('local_phone', 15)->nullable();
            $table->boolean('current_location')->default(true);
            $table->text('address')->nullable();
            $table->foreignId('people_id')->constrained('people', 'id');
            $table->foreignId('country_id')->constrained();
            $table->foreignId('state_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('people_addresses');
    }
}
