<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flats', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('title')->default('Квартира');
            $table->integer('status_id')->unsigned();
            $table->float('full_space')->unsigned();
            $table->integer('floor_count')->unsigned();
            $table->float('living_space')->unsigned();
            $table->integer('room_count')->unsigned();
            $table->float('balconyless_space')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flats');
    }
}
