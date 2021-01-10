<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shiporders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('people_id')->unsigned();
            //address in same table because it has just one address
            $table->string('shipto_name', 60);
            $table->string('shipto_address', 100);
            $table->string('shipto_city', 50);
            $table->string('shipto_country', 30);
            $table->timestamps();
            $table->softDeletes();
            $table->index(['id']);
            $table->foreign('people_id')->references('id')->on('people');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shiporders');
    }
}
