<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ship_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shiporder_id');
            $table->string('title', 60);
            $table->string('note', 60);
            $table->integer('quantity');
            $table->unsignedDecimal('price', 10, 2);
            $table->foreign('shiporder_id')->references('id')->on('shiporders');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ship_items');
    }
}
