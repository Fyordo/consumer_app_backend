<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientFlatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_flat', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->integer('client_id')->unsigned();
            $table->integer('flat_id')->unsigned();
            $table->integer('client_flat_status_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_flat');
    }
}
