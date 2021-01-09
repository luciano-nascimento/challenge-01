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
            $table->unsignedBigInteger('order_id');
            //avoid create relationship to persons table, because maybe we receive
            //order first then person
            $table->unsignedBigInteger('people_id');
            //address in same table because it has just one address
            $table->string('shipto_name', 60);
            $table->string('shipto_address', 100);
            $table->string('shipto_city', 50);
            $table->string('shipto_country', 30);
            $table->timestamps();
            $table->softDeletes();
            $table->index(['order_id']);
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
