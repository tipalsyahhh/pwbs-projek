<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeranjangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keranjang', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('menu_id')->nullable();
            $table->timestamps();

            // Tambahkan foreign keys
            $table->foreign('user_id')->references('id')->on('login')->onDelete('cascade');
            $table->foreign('menu_id')->references('id')->on('postingan')->onDelete('cascade');
        });
    }

    /**
     * Rollback the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('keranjang');
    }
}

