<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('pelanggan');
            $table->char('no_meja', 15);
            $table->char('total', 25);
            $table->char('bayar', 25);
            $table->boolean('status');
            $table->bigInteger('pegawais_id')->nullable()->unsigned();
            $table->index('pegawais_id')->nullable();
            $table->foreign('pegawais_id')->nullable()->references('id')->on('pegawais')->onDelete('cascade');
            $table->bigInteger('users_id')->nullable()->unsigned();
            $table->index('users_id')->nullable();
            $table->foreign('users_id')->nullable()->references('id')->on('users')->onDelete('cascade');
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('transaksis');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
