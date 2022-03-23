<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('qty');
            $table->integer('total');
            $table->bigInteger('transaksis_id')->nullable()->unsigned();
            $table->index('transaksis_id')->nullable();
            $table->foreign('transaksis_id')->nullable()->references('id')->on('transaksis')->onDelete('cascade');
            $table->bigInteger('menus_id')->nullable()->unsigned();
            $table->index('menus_id')->nullable();
            $table->foreign('menus_id')->nullable()->references('id')->on('menus')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
